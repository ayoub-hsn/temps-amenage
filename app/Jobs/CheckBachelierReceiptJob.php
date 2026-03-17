<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Models\PaymentBacheliers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckBachelierReceiptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $payment;

    public $timeout = 120; // prevent infinite OCR freeze
    public $tries = 2;

    public function __construct(PaymentBacheliers $payment)
    {
        $this->payment = $payment;
    }

    public function handle()
    {
        try {

            $payment = PaymentBacheliers::find($this->payment->id);

            if (!$payment || $payment->verification == 1) return;

            if ($payment->etat_payment === "Complete(Fonctionnaire à l'UH1)") {

                $payment->verification = 1;
                $payment->montant_detecter = 0;
                $payment->save();

                Log::info("OCR Job skipped - UH1 staff payment", [
                    'payment_id' => $payment->id
                ]);

                return;
            }

            $expectedAmount = round((float)$payment->montant_paye, 2);

            /*
            =====================================================
            LOCATE IMAGE
            =====================================================
            */

            $imagePath = public_path(ltrim($payment->document, '/'));

            if (empty($payment->document) || !file_exists($imagePath) || !is_file($imagePath) || !is_readable($imagePath)) {
                Log::error("OCR Job Error: File not found or unreadable", [
                    'path' => $imagePath,
                    'payment_id' => $payment->id,
                    'document_value' => $payment->document,
                ]);
                return; // skip this job
            }

            Log::info("OCR Job: Found image", [
                'imagePath' => $imagePath,
                'payment_id' => $payment->id
            ]);

            /*
            =====================================================
            OCR CALL
            =====================================================
            */

            $response = Http::timeout(120)
                ->retry(2,3000)
                ->asMultipart()
                ->post('https://api.ocr.space/parse/image', [
                    'apikey'=>env('OCR_SPACE_API_KEY'),
                    'language'=>'fre',
                    'OCREngine'=>'2',
                    'file'=>fopen($imagePath,'r')
                ]);

            $text = $response->json()['ParsedResults'][0]['ParsedText'] ?? '';

            if (!$text) return;

            /*
            =====================================================
            TEXT NORMALIZATION
            =====================================================
            */

            $text = strtolower(trim($text));

            $text = preg_replace('/\bI(?=\d)/','1',$text);
            $text = preg_replace('/\bO(?=\d)/','0',$text);
            $text = str_replace('|','1',$text);

            $text = str_replace(
                ['millc','mili','milié','milc'],
                'mille',
                $text
            );

            $lines = preg_split('/\r\n|\r|\n/',$text);

            /*
            =====================================================
            DIRECT "MONTANT" EXTRACTION (HIGH PRIORITY)
            =====================================================
            */

            for ($i = 0; $i < count($lines); $i++) {

                if (str_contains($lines[$i], 'montant')) {

                    // search next 3 lines
                    for ($j = 1; $j <= 3; $j++) {

                        if (!isset($lines[$i+$j])) continue;

                        if (preg_match('/([\d\.,]+)/',$lines[$i+$j],$m)) {

                            $value = str_replace([',',' '],'',$m[1]);
                            $detectedAmount = (float)$value;

                            if ($detectedAmount > 1000 && $detectedAmount < 200000) {

                                Log::info("OCR Job: Montant detected directly",[
                                    'amount'=>$detectedAmount,
                                    'payment_id'=>$payment->id
                                ]);

                                $payment->montant_detecter = $detectedAmount;

                                $tolerance = max(1,$expectedAmount * 0.01);

                                $payment->verification =
                                    abs($detectedAmount - $expectedAmount) <= $tolerance ? 1 : 2;

                                $payment->save();

                                return; // 🚀 STOP JOB HERE
                            }
                        }
                    }
                }
            }

            $candidates = [];
            $numberPool = [];

            /*
            =====================================================
            BANK PATTERN PRIORITY
            =====================================================
            */

            if (preg_match('/bp\s*dh.*?(\d{4,6})/i',$text,$match)) {

                $value = $this->normalizeMoroccanNumber($match[1]);

                $candidates[] = [
                    'value'=>$value,
                    'score'=>500
                ];
            }

            /*
            =====================================================
            NUMBER EXTRACTION + SCORING
            =====================================================
            */

            foreach ($lines as $line) {

                if (!preg_match_all('/\d[\d\s\.,]*\d/',$line,$matches)) continue;

                foreach ($matches[0] as $raw) {

                    $token = trim($raw);
                    $clean = str_replace(' ','',$token);

                    if (preg_match('/[a-z]'.$token.'|'.$token.'[a-z]/i',$line)) continue;

                    if (preg_match('/^\d{1,2}[.\-\/]\d{1,2}[.\-\/]\d{2,4}$/',$clean)) continue;
                    if (preg_match('/^(19|20)\d{2}$/',$clean)) continue;

                    $value = $this->normalizeMoroccanNumber($clean);

                    if ($value < 1000 || $value > 200000) continue;

                    $score = 100;

                    /*
                    Context scoring
                    */

                    if (str_contains($line,'montant')) $score+=250;
                    if (str_contains($line,'virement')) $score+=150;
                    if (str_contains($line,'somme')) $score+=120;
                    if (str_contains($line,'dh')) $score+=100;

                    /*
                    Fraud protection
                    */

                    if (preg_match('/(rib|iban|compte|ref|réf|code|agence)/i',$line)){
                        $score -= 500;
                    }

                    /*
                    Payment probability model
                    */

                    $diff = abs($value - $expectedAmount);

                    if ($diff < 30) $score += 700;
                    if ($diff < 100) $score += 500;
                    if ($diff < 500) $score += 250;

                    $percentageDiff = ($diff / max($expectedAmount,1)) * 100;

                    if ($percentageDiff < 2) $score += 600;

                    $candidates[] = [
                        'value'=>$value,
                        'score'=>$score
                    ];

                    $numberPool[] = number_format($value, 2, '.', '');
                }
            }

            /*
            =====================================================
            WRITTEN FRENCH DETECTION
            =====================================================
            */

            if (preg_match('/quin.{0,3}ze/i',$text)) {

                if (preg_match('/mil{1,2}[ei]/i',$text)) {

                    $candidates[] = [
                        'value'=>15000,
                        'score'=>1000
                    ];
                }
            }

            /*
            =====================================================
            FREQUENCY MODEL
            =====================================================
            */

            if (!empty($numberPool)) {

                $counts = array_count_values($numberPool);
                arsort($counts);

                $freqValue = (float)array_key_first($counts);

                $candidates[] = [
                    'value'=>$freqValue,
                    'score'=>900
                ];
            }

            if (empty($candidates)) return;

            /*
            =====================================================
            FINAL DECISION ENGINE
            =====================================================
            */

            usort($candidates,function($a,$b){
                return $b['score'] <=> $a['score'];
            });

            $detectedAmount = $this->stabilizeAmount($candidates[0]['value']);

            $payment->montant_detecter = $detectedAmount;

            $tolerance = max(1,$expectedAmount * 0.01);

            $payment->verification =
                abs($detectedAmount - $expectedAmount) <= $tolerance ? 1 : 2;

            $payment->save();

        }
        catch(\Exception $e){
            Log::error("OCR Queue Error : ".$e->getMessage());
        }
    }

    private function stabilizeAmount(float $value)
    {
        return round($value,2);
    }

    private function normalizeMoroccanNumber($num)
    {
        if (strpos($num, ',')!==false && strpos($num,'.')!==false) {
            $num=str_replace('.','',$num);
            $num=str_replace(',','.',$num);
            return (float)$num;
        }

        if (strpos($num, ',')!==false) {
            return (float)str_replace(',','.',$num);
        }

        if (substr_count($num,'.')>1) {
            return (float)str_replace('.','',$num);
        }

        return (float)$num;
    }
}
