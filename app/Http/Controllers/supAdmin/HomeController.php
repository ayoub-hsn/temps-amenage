<?php

namespace App\Http\Controllers\supAdmin;

use Mpdf\Mpdf;
use App\Models\Filiere;
use App\Models\Bachelier;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class HomeController extends Controller
{
    public function index(){
        $FilieresMasterCount = Filiere::where('type',1)->where('active',1)->count();
        $filieresPasserelleCount = Filiere::where('type',2)->where('active',1)->count();
        $filieresBachelierCount = Filiere::where('type',3)->where('active',1)->count();

        // ✅ Count only distinct (email, filiere) pairs for each table
        $filieresMasterCandidatCount = DB::table('student_masters')
            ->select('email', 'filiere')
            ->distinct()
            ->count();
        // ->distinct('email')
        //     ->count('email');

        $filieresPasserelleCandidatCount = DB::table('student_passerelles')
            ->select('email', 'filiere')
            ->distinct()
            ->count();

        $filieresBachelierCandidatCount = DB::table('bacheliers')
            ->select('email', 'filiere')
            ->distinct()
            ->count();

        $etablissementStats = Etablissement::has('filiere')->withCount(['studentMaster', 'studentPasserelle','studentBachelier'])
            ->get(['id', 'nom', 'nom_abrev']);

        $labels = $etablissementStats->pluck('nom_abrev'); // Chart labels (abbreviated names)
        $dataMaster = $etablissementStats->pluck('student_master_count'); // Master student counts
        $dataPasserelle = $etablissementStats->pluck('student_passerelle_count'); // Licence (Accées S5) student counts
        $dataBachelier = $etablissementStats->pluck('student_bachelier_count'); // Licence (Accées S1) student counts
        return view('sup-admin.dashboard',compact(
            'FilieresMasterCount',
            'filieresPasserelleCount',
            'filieresBachelierCount',
            'filieresMasterCandidatCount',
            'filieresPasserelleCandidatCount',
            'filieresBachelierCandidatCount',
            'labels',
            'dataMaster',
            'dataPasserelle',
            'dataBachelier'
        ));
    }

    public function downloadDataByEtab(){
        $etablissementStats = Etablissement::has('filiere')->withCount(['studentMaster', 'studentPasserelle','studentBachelier'])
        ->get(['id', 'nom', 'nom_abrev']);

        $pdf = Pdf::loadView('sup-admin.pdf.etablissement_stats', compact('etablissementStats'));

        return $pdf->download('statistiques_etablissements.pdf');
    }


    public function downloadDataByFiliere()
    {
        $etablissements = Etablissement::has('filiere')->get();
        $allData = [];

        foreach ($etablissements as $etablissement) {
            // Master filières
            $filieresMaster = DB::table('filieres')
                ->select('filieres.nom_abrv','filieres.nom_complet', 'users.name as responsable', DB::raw('COUNT(student_masters.id) as students_count'))
                ->leftJoin('student_masters', function ($join) use ($etablissement) {
                    if ($etablissement->multiple_choix_filiere_master == 1) {
                        $join->on(function ($q) {
                            $q->on('student_masters.filiere_choix_1', '=', 'filieres.id')
                            ->orOn('student_masters.filiere_choix_2', '=', 'filieres.id')
                            ->orOn('student_masters.filiere_choix_3', '=', 'filieres.id');
                        });
                    } else {
                        $join->on('student_masters.filiere', '=', 'filieres.id');
                    }
                })
                ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id')
                ->where('filieres.type', 1)
                ->where('filieres.etablissement_id', $etablissement->id)
                ->groupBy('filieres.nom_complet', 'users.name')
                ->get();

            // Licence (Accès S5)
            $filieresPasserelle = DB::table('filieres')
                ->select('filieres.nom_abrv','filieres.nom_complet', 'users.name as responsable', DB::raw('COUNT(student_passerelles.id) as students_count'))
                ->leftJoin('student_passerelles', function ($join) use ($etablissement) {
                    if ($etablissement->multiple_choix_filiere_passerelle == 1) {
                        $join->on(function ($q) {
                            $q->on('student_passerelles.filiere_choix_1', '=', 'filieres.id')
                            ->orOn('student_passerelles.filiere_choix_2', '=', 'filieres.id')
                            ->orOn('student_passerelles.filiere_choix_3', '=', 'filieres.id');
                        });
                    } else {
                        $join->on('student_passerelles.filiere', '=', 'filieres.id');
                    }
                })
                ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id')
                ->where('filieres.type', 2)
                ->where('filieres.etablissement_id', $etablissement->id)
                ->groupBy('filieres.nom_complet', 'users.name')
                ->get();

            // Licence (Accès S1)
            $filieresBacheliers = DB::table('filieres')
                ->select('filieres.nom_abrv','filieres.nom_complet', 'users.name as responsable', DB::raw('COUNT(bacheliers.id) as students_count'))
                ->leftJoin('bacheliers', function ($join) use ($etablissement) {
                    if ($etablissement->multiple_choix_filiere_passerelle == 1) {
                        $join->on(function ($q) {
                            $q->on('bacheliers.filiere_choix_1', '=', 'filieres.id')
                            ->orOn('bacheliers.filiere_choix_2', '=', 'filieres.id')
                            ->orOn('bacheliers.filiere_choix_3', '=', 'filieres.id');
                        });
                    } else {
                        $join->on('bacheliers.filiere', '=', 'filieres.id');
                    }
                })
                ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id')
                ->where('filieres.type', 3)
                ->where('filieres.etablissement_id', $etablissement->id)
                ->groupBy('filieres.nom_complet', 'users.name')
                ->get();

            $allData[] = [
                'etablissement' => $etablissement->nom,
                'master' => $filieresMaster,
                'passerelle' => $filieresPasserelle,
                'bachelier' => $filieresBacheliers
            ];
        }

        // ✅ Render the Blade view
        $html = View::make('sup-admin.pdf.filiere_stats', compact('allData'))->render();

        // ✅ Ensure tmp directory exists
        if (!file_exists(storage_path('mpdf'))) {
            mkdir(storage_path('mpdf'), 0775, true);
        }

        // ✅ Create mPDF instance with writable tempDir
        $mpdf = new Mpdf([
            'mode' => 'utf-8',
            'default_font' => 'dejavusans',
            'autoLangToFont' => true,
            'autoScriptToLang' => true,
            'tempDir' => storage_path('mpdf') // ✅ Fix: use writable directory
        ]);

        $mpdf->WriteHTML($html);
        return $mpdf->Output('statistiques_filieres_par_etablissement.pdf', 'I');
    }
}
