<?php

namespace App\Http\Controllers\supAdmin;

use App\Models\Filiere;
use App\Models\Bachelier;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

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
}
