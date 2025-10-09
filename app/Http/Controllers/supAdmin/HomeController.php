<?php

namespace App\Http\Controllers\supAdmin;

use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
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
        return view('sup-admin.dashboard',compact(
            'FilieresMasterCount',
            'filieresPasserelleCount',
            'filieresMasterCandidatCount',
            'filieresPasserelleCandidatCount',
            'labels',
            'dataMaster',
            'dataPasserelle'
        ));
    }
}
