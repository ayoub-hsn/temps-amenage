<?php

namespace App\Http\Controllers\adminEtab;

use Carbon\Carbon;
use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function index()
     {
         $etablissementId = auth()->user()->etablissement->id;
     
         // Total counts
         $studentMasterCount = StudentMaster::where('etablissement_id', $etablissementId)->count();
         $studentPasserelleCount = StudentPasserelle::where('etablissement_id', $etablissementId)->count();
     
         // === Passerelle stats ===
         $beforeTodayPasserelle = StudentPasserelle::where('etablissement_id', $etablissementId)
             ->where('created_at', '<', Carbon::today())
             ->count();
     
         $todayPasserelle = StudentPasserelle::where('etablissement_id', $etablissementId)
             ->whereDate('created_at', Carbon::today())
             ->count();
     
         if ($beforeTodayPasserelle > 0) {
             $percentageIncreasepasserelle = ($todayPasserelle / $beforeTodayPasserelle) * 100;
         } else {
             $percentageIncreasepasserelle = $todayPasserelle > 0 ? 100 : 0;
         }
         $percentageIncreasepasserelle = round($percentageIncreasepasserelle, 2);
     
         // === Master stats ===
         $beforeTodayMaster = StudentMaster::where('etablissement_id', $etablissementId)
             ->where('created_at', '<', Carbon::today())
             ->count();
     
         $todayMaster = StudentMaster::where('etablissement_id', $etablissementId)
             ->whereDate('created_at', Carbon::today())
             ->count();
     
         if ($beforeTodayMaster > 0) {
             $percentageIncreaseMaster = ($todayMaster / $beforeTodayMaster) * 100;
         } else {
             $percentageIncreaseMaster = $todayMaster > 0 ? 100 : 0;
         }
         $percentageIncreaseMaster = round($percentageIncreaseMaster, 2);


         // === Filiere stats ===
         $filieresCount = Filiere::where('etablissement_id',$etablissementId)->count();




        // === Global Master stats ===
        $multipleChoixFiliereMaster = auth()->user()->etablissement->multiple_choix_filiere_master == 1;

        if (!$multipleChoixFiliereMaster) {
            // Single filiere per student - simple group by filiere
            $statsMaster = DB::table('filieres')
            ->leftJoin('student_masters', 'filieres.id', '=', 'student_masters.filiere')
            ->select(
                'filieres.id',
                'filieres.nom_complet',
                DB::raw('COUNT(student_masters.id) as postulants_count')
            )
            ->where('filieres.etablissement_id', $etablissementId)
            ->where('filieres.type',1)
            ->groupBy('filieres.id', 'filieres.nom_complet')
            ->get();
        
        } else {
            // Multiple filiere choices per student
            // We'll gather counts for each filiere appearing in any of the choice columns

            // Step 1: get counts from filiere_choix_1
            $choice1 = DB::table('student_masters')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_masters.id) as postulants_count'))
                ->join('filieres', 'student_masters.filiere_choix_1', '=', 'filieres.id')
                ->where('filieres.etablissement_id', $etablissementId)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            // Step 2: get counts from filiere_choix_2
            $choice2 = DB::table('student_masters')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_masters.id) as postulants_count'))
                ->join('filieres', 'student_masters.filiere_choix_2', '=', 'filieres.id')
                ->where('filieres.etablissement_id', $etablissementId)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            // Step 3: get counts from filiere_choix_3
            $choice3 = DB::table('student_masters')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_masters.id) as postulants_count'))
                ->join('filieres', 'student_masters.filiere_choix_3', '=', 'filieres.id')
                ->where('filieres.etablissement_id', $etablissementId)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            // Union all three queries using unionAll()
            $union = $choice1->unionAll($choice2)->unionAll($choice3);

            // Now wrap the union as a subquery and sum the counts per filiere
            $statsMaster = DB::table(DB::raw("({$union->toSql()}) as sub"))
                ->mergeBindings($union) // Important: merge bindings to avoid parameter errors
                ->select('id', 'nom_complet', DB::raw('SUM(postulants_count) as postulants_count'))
                ->groupBy('id', 'nom_complet')
                ->get();


        }


        // === Global Passerelle stats ===
        $multipleChoixFilierePasserelle = auth()->user()->etablissement->multiple_choix_filiere_passerelle == 1;

        if (!$multipleChoixFilierePasserelle) {
            // Single filiere per student - simple group by filiere
            $statsPasserelle = DB::table('filieres')
                ->leftJoin('student_passerelles', 'filieres.id', '=', 'student_passerelles.filiere')
                ->select(
                    'filieres.id',
                    'filieres.nom_complet',
                    DB::raw('COUNT(student_passerelles.id) as postulants_count')
                )
                ->where('filieres.etablissement_id', $etablissementId)
                ->where('filieres.type', 2) // type 2 for passerelle
                ->groupBy('filieres.id', 'filieres.nom_complet')
                ->get();

        } else {
            // Multiple filiere choices per passerelle student

            $choice1 = DB::table('student_passerelles')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_passerelles.id) as postulants_count'))
                ->join('filieres', 'student_passerelles.filiere_choix_1', '=', 'filieres.id')
                ->where('filieres.etablissement_id', $etablissementId)
                ->where('filieres.type', 2)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            $choice2 = DB::table('student_passerelles')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_passerelles.id) as postulants_count'))
                ->join('filieres', 'student_passerelles.filiere_choix_2', '=', 'filieres.id')
                ->where('filieres.etablissement_id', $etablissementId)
                ->where('filieres.type', 2)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            $choice3 = DB::table('student_passerelles')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_passerelles.id) as postulants_count'))
                ->join('filieres', 'student_passerelles.filiere_choix_3', '=', 'filieres.id')
                ->where('filieres.etablissement_id', $etablissementId)
                ->where('filieres.type', 2)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            $union = $choice1->unionAll($choice2)->unionAll($choice3);

            $statsPasserelle = DB::table(DB::raw("({$union->toSql()}) as sub"))
                ->mergeBindings($union) // fix: mergeBindings directly on $union, not $union->getQuery()
                ->select('id', 'nom_complet', DB::raw('SUM(postulants_count) as postulants_count'))
                ->groupBy('id', 'nom_complet')
                ->get();

        }

     
         return view("admin-etab.dashboard", compact(
             'studentMasterCount',
             'studentPasserelleCount',
             'percentageIncreasepasserelle',
             'percentageIncreaseMaster',
             'filieresCount',
             'statsMaster',
             'statsPasserelle'
         ));
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
