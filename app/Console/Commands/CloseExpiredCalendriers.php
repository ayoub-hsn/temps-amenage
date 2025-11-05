<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Bachelier;
use App\Models\Calendrier;
use App\Models\StudentMaster;
use Illuminate\Console\Command;
use App\Models\StudentPasserelle;

class CloseExpiredCalendriers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:close-expired-calendriers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Ferme automatiquement les programmes dont la date de fin est dépassée';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now();
        $calendriers = Calendrier::with('etablissement')->get();

        foreach ($calendriers as $calendrier) {
            $etab = $calendrier->etablissement;

            if (!$etab) continue;

            // === Master ===
            if ($calendrier->date_fin_master && $today->greaterThanOrEqualTo(Carbon::parse($calendrier->date_fin_master))) {
                if ($etab->master_ouvert != 0) {
                    $etab->master_ouvert = 0;
                    $this->info("Master fermé pour {$etab->nom}");

                    // Update confirmation_student for StudentMaster
                    StudentMaster::where('etablissement_id', $etab->id)
                        ->update(['confirmation_student' => 1]);

                    $this->info("✅ StudentMaster mis à jour confirmation_student pour {$etab->nom}");
                }
            }

            // === Passerelle ===
            if ($calendrier->date_fin_passerelle && $today->greaterThanOrEqualTo(Carbon::parse($calendrier->date_fin_passerelle))) {
                if ($etab->passerelle_ouvert != 0) {
                    $etab->passerelle_ouvert = 0;
                    $this->info("Passerelle fermée pour {$etab->nom}");

                    // Update confirmation_student for StudentPasserelle
                    StudentPasserelle::where('etablissement_id', $etab->id)
                        ->update(['confirmation_student' => 1]);

                    $this->info("✅ StudentPasserelle mis à jour confirmation_student pour {$etab->nom}");
                }
            }

            // === Bachelier ===
            if ($calendrier->date_fin_bachelier && $today->greaterThanOrEqualTo(Carbon::parse($calendrier->date_fin_bachelier))) {
                if ($etab->bachelier_ouvert != 0) {
                    $etab->bachelier_ouvert = 0;
                    $this->info("Bachelier fermé pour {$etab->nom}");

                    // Update confirmation_student for Bachelier
                    Bachelier::where('etablissement_id', $etab->id)
                        ->update(['confirmation_student' => 1]);

                    $this->info("✅ Bachelier mis à jour confirmation_student pour {$etab->nom}");
                }
            }

            $etab->save();
        }

        $this->info('✅ Vérification terminée. Les établissements concernés ont été mis à jour.');
    }
}

