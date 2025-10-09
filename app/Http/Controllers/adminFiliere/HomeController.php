<?php

namespace App\Http\Controllers\adminFiliere;

use Carbon\Carbon;
use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Get filiere IDs for Master and Passerelle
        $filieresMasterIds = Filiere::where('responsable_id', Auth::id())->where('type', 1)->pluck('id');
        $filieresPasserelleIds = Filiere::where('responsable_id', Auth::id())->where('type', 2)->pluck('id');

        // === Total Counts ===
        $studentsMasterCount = StudentMaster::whereIn('filiere', $filieresMasterIds)
            ->orWhereIn('filiere_choix_1', $filieresMasterIds)
            ->orWhereIn('filiere_choix_2', $filieresMasterIds)
            ->orWhereIn('filiere_choix_3', $filieresMasterIds)
            ->count();

        $studentsPasserelleCount = StudentPasserelle::whereIn('filiere', $filieresPasserelleIds)
            ->orWhereIn('filiere_choix_1', $filieresPasserelleIds)
            ->orWhereIn('filiere_choix_2', $filieresPasserelleIds)
            ->orWhereIn('filiere_choix_3', $filieresPasserelleIds)
            ->count();

        // === Master Stats ===
        $beforeTodayMaster = StudentMaster::where(function ($query) use ($filieresMasterIds) {
                $query->whereIn('filiere', $filieresMasterIds)
                    ->orWhereIn('filiere_choix_1', $filieresMasterIds)
                    ->orWhereIn('filiere_choix_2', $filieresMasterIds)
                    ->orWhereIn('filiere_choix_3', $filieresMasterIds);
            })
            ->where('created_at', '<', Carbon::today())
            ->count();

        $todayMaster = StudentMaster::where(function ($query) use ($filieresMasterIds) {
                $query->whereIn('filiere', $filieresMasterIds)
                    ->orWhereIn('filiere_choix_1', $filieresMasterIds)
                    ->orWhereIn('filiere_choix_2', $filieresMasterIds)
                    ->orWhereIn('filiere_choix_3', $filieresMasterIds);
            })
            ->whereDate('created_at', Carbon::today())
            ->count();

        $percentageIncreaseMaster = $beforeTodayMaster > 0
            ? round(($todayMaster / $beforeTodayMaster) * 100, 2)
            : ($todayMaster > 0 ? 100 : 0);

        // === Passerelle Stats ===
        $beforeTodayPasserelle = StudentPasserelle::where(function ($query) use ($filieresPasserelleIds) {
                $query->whereIn('filiere', $filieresPasserelleIds)
                    ->orWhereIn('filiere_choix_1', $filieresPasserelleIds)
                    ->orWhereIn('filiere_choix_2', $filieresPasserelleIds)
                    ->orWhereIn('filiere_choix_3', $filieresPasserelleIds);
            })
            ->where('created_at', '<', Carbon::today())
            ->count();

        $todayPasserelle = StudentPasserelle::where(function ($query) use ($filieresPasserelleIds) {
                $query->whereIn('filiere', $filieresPasserelleIds)
                    ->orWhereIn('filiere_choix_1', $filieresPasserelleIds)
                    ->orWhereIn('filiere_choix_2', $filieresPasserelleIds)
                    ->orWhereIn('filiere_choix_3', $filieresPasserelleIds);
            })
            ->whereDate('created_at', Carbon::today())
            ->count();

        $percentageIncreasePasserelle = $beforeTodayPasserelle > 0
            ? round(($todayPasserelle / $beforeTodayPasserelle) * 100, 2)
            : ($todayPasserelle > 0 ? 100 : 0);

        $filiereMasterCount = Filiere::where('responsable_id', Auth::id())->where('type', 1)->count();
        $filierePasserelleCount = Filiere::where('responsable_id', Auth::id())->where('type', 2)->count();


        $multipleChoixFiliereMaster = auth()->user()->filiere->etablissement->multiple_choix_filiere_master == 1;

        if (!$multipleChoixFiliereMaster) {
            $statsMaster = DB::table('filieres')
                ->leftJoin('student_masters', 'filieres.id', '=', 'student_masters.filiere')
                ->select(
                    'filieres.id',
                    'filieres.nom_complet',
                    DB::raw('COUNT(student_masters.id) as postulants_count')
                )
            
                ->where('filieres.type', 1)
                ->whereIn('filieres.id', $filieresMasterIds)
                ->groupBy('filieres.id', 'filieres.nom_complet')
                ->get();
        } else {
            $choice1 = DB::table('student_masters')
                ->join('filieres', 'student_masters.filiere_choix_1', '=', 'filieres.id')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_masters.id) as postulants_count'))
                ->whereIn('filieres.id', $filieresMasterIds)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            $choice2 = DB::table('student_masters')
                ->join('filieres', 'student_masters.filiere_choix_2', '=', 'filieres.id')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_masters.id) as postulants_count'))
                ->whereIn('filieres.id', $filieresMasterIds)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            $choice3 = DB::table('student_masters')
                ->join('filieres', 'student_masters.filiere_choix_3', '=', 'filieres.id')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_masters.id) as postulants_count'))
                ->whereIn('filieres.id', $filieresMasterIds)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            $union = $choice1->unionAll($choice2)->unionAll($choice3);

            $statsMaster = DB::table(DB::raw("({$union->toSql()}) as sub"))
                ->mergeBindings($union)
                ->select('id', 'nom_complet', DB::raw('SUM(postulants_count) as postulants_count'))
                ->groupBy('id', 'nom_complet')
                ->get();
        }

        $multipleChoixFilierePasserelle = auth()->user()->filiere->etablissement->multiple_choix_filiere_passerelle == 1;

        if (!$multipleChoixFilierePasserelle) {
            $statsPasserelle = DB::table('filieres')
                ->leftJoin('student_passerelles', 'filieres.id', '=', 'student_passerelles.filiere')
                ->select(
                    'filieres.id',
                    'filieres.nom_complet',
                    DB::raw('COUNT(student_passerelles.id) as postulants_count')
                )
                ->where('filieres.type', 2)
                ->whereIn('filieres.id', $filieresPasserelleIds)
                ->groupBy('filieres.id', 'filieres.nom_complet')
                ->get();

        } else {
            $choice1 = DB::table('student_passerelles')
                ->join('filieres', 'student_passerelles.filiere_choix_1', '=', 'filieres.id')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_passerelles.id) as postulants_count'))
                ->whereIn('filieres.id', $filieresPasserelleIds)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            $choice2 = DB::table('student_passerelles')
                ->join('filieres', 'student_passerelles.filiere_choix_2', '=', 'filieres.id')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_passerelles.id) as postulants_count'))
                ->whereIn('filieres.id', $filieresPasserelleIds)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            $choice3 = DB::table('student_passerelles')
                ->join('filieres', 'student_passerelles.filiere_choix_3', '=', 'filieres.id')
                ->select('filieres.id', 'filieres.nom_complet', DB::raw('count(student_passerelles.id) as postulants_count'))
                ->whereIn('filieres.id', $filieresPasserelleIds)
                ->groupBy('filieres.id', 'filieres.nom_complet');

            $union = $choice1->unionAll($choice2)->unionAll($choice3);

            $statsPasserelle = DB::table(DB::raw("({$union->toSql()}) as sub"))
                ->mergeBindings($union)
                ->select('id', 'nom_complet', DB::raw('SUM(postulants_count) as postulants_count'))
                ->groupBy('id', 'nom_complet')
                ->get();
        }
        return view('admin-filiere.dashboard',compact(
            'studentsMasterCount',
            'studentsPasserelleCount',
            'percentageIncreaseMaster',
            'percentageIncreasePasserelle',
            'filiereMasterCount',
            'filierePasserelleCount',
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
