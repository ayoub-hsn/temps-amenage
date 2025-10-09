<?php

namespace App\Http\Controllers\visiteur;

use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $FilieresMasterCount = Filiere::where('type',1)->count();
        $filieresPasserelleCount = Filiere::where('type',2)->count();
        $filieresMasterCandidatCount = StudentMaster::count();
        $filieresPasserelleCandidatCount = StudentPasserelle::count();

        $etablissementStats = Etablissement::withCount(['studentMaster', 'studentPasserelle'])
            ->get(['id', 'nom', 'nom_abrev']);

        $labels = $etablissementStats->pluck('nom_abrev'); // Chart labels (abbreviated names)
        $dataMaster = $etablissementStats->pluck('student_master_count'); // Master student counts
        $dataPasserelle = $etablissementStats->pluck('student_passerelle_count'); // Passerelle student counts
        return view('visiteur.dashboard',compact(
            'FilieresMasterCount',
            'filieresPasserelleCount',
            'filieresMasterCandidatCount',
            'filieresPasserelleCandidatCount',
            'labels',
            'dataMaster',
            'dataPasserelle'
        ));
    }

    public function downloadDataByEtab(){
        $etablissementStats = Etablissement::withCount(['studentMaster', 'studentPasserelle'])
        ->get(['id', 'nom', 'nom_abrev']);

        $pdf = Pdf::loadView('visiteur.pdf.etablissement_stats', compact('etablissementStats'));

        return $pdf->download('statistiques_etablissements.pdf');
    }


    public function downloadDataByFiliere()
    {
        // Simple function to reverse UTF-8 strings (basic Arabic fix)
        function reverseArabicText($text) {
            $chars = preg_split('//u', $text, -1, PREG_SPLIT_NO_EMPTY);
            return implode('', array_reverse($chars));
        }

        $etablissements = Etablissement::all();
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

            // Passerelle filières
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

            // Reverse Arabic text in master filieres
            foreach ($filieresMaster as $filiere) {
                if (preg_match('/\p{Arabic}/u', $filiere->nom_complet)) {
                    $filiere->nom_complet = reverseArabicText($filiere->nom_complet);
                }
            }

            // Reverse Arabic text in passerelle filieres
            foreach ($filieresPasserelle as $filiere) {
                if (preg_match('/\p{Arabic}/u', $filiere->nom_complet)) {
                    $filiere->nom_complet = reverseArabicText($filiere->nom_complet);
                }
            }

            $allData[] = [
                'etablissement' => $etablissement->nom,
                'master' => $filieresMaster,
                'passerelle' => $filieresPasserelle,
            ];
        }

        $pdf = Pdf::loadView('visiteur.pdf.filiere_stats', compact('allData'));

        return $pdf->download('statistiques_filieres_par_etablissement.pdf');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
