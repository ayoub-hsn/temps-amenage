<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use App\Models\Actualite;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;

class HomeController extends Controller
{
    public function welcome(){
        return view('front-end.welcome');
    }

    public function contact(){
        return view('front-end.contact');
    }

    public function etablissements(){
        $fsjp = Etablissement::whereId(1)->first();
        $encg = Etablissement::whereId(2)->first();
        $fst = Etablissement::whereId(3)->first();
        $ensa = Etablissement::whereId(4)->first();
        $i3s = Etablissement::whereId(5)->first();
        $i2s = Etablissement::whereId(6)->first();
        $esef = Etablissement::whereId(7)->first();
        $flash = Etablissement::whereId(8)->first();
        $feg = Etablissement::whereId(9)->first();
        return view('front-end.etablissements',compact('fsjp','encg','fst','ensa','i3s','i2s','esef','flash','feg'));
    }

    public function licenceExcellenceMaster(){
        $actualites = Actualite::where('published_at', '<=', \Carbon\Carbon::now())
                               ->where('finished_at', '>=', \Carbon\Carbon::now())
                               ->get();

        $etablissements = Etablissement::all();

        return view('front-end.licenceExcellenceMaster', compact('actualites','etablissements'));
    }

    public function welcomeMaster(Etablissement $etablissement){
        if($etablissement->master_ouvert == 0){
            return view('front-end.master.preinscription-master-form-fermer',compact('etablissement'));
        }
        return view('front-end.master.welcomeMasterFirstForm',compact('etablissement'));
    }

    public function welcomeMasterApply(Etablissement $etablissement,Request $request){
        $request->validate([
            'cne' => 'required|max:20',
            'cin' => 'required|max:10'
        ]);

        // $listeFiliereID = Filiere::
        // where('etablissement_id',$etablissement->id)
        // ->where('type',1)
        // ->pluck('id');


        // StudentMaster::where()
        // ->where('CNE', $request->cne)
        // ->orWhere('CIN', $request->cin)->first();

        // if($etablissement->multiple_choix_filiere_master){  //multiple choix
        //     $studentMaster = StudentMaster::where(function($query) use ($request) {
        //         $query->where('CNE', $request->cne)
        //               ->where('CIN', $request->cin);
        //     })
        //     ->where(function($query) use ($listeFiliereID) {
        //         $query->whereIn('filiere_choix_1', $listeFiliereID)
        //               ->orWhereIn('filiere_choix_2', $listeFiliereID)
        //               ->orWhereIn('filiere_choix_3', $listeFiliereID);
        //     })
        //     ->first();
        // }else{  // un seul choix
        //     $studentMaster = StudentMaster::where(function($query) use ($request) {
        //         $query->where('CNE', $request->cne)
        //               ->where('CIN', $request->cin);
        //     })
        //     ->whereIn('filiere',$listeFiliereID)
        //     ->first();
        // }

        // if($studentMaster){
        //     return back()->with('error_student_exist','vous avez déjà postulé ici');
        // }

        return redirect()->route('welcomeMaster.apply.form',['etablissement' => $etablissement->id])->with([
            'etablissement' => $etablissement->id,
            'cne' => $request->cne,
            'cin' => $request->cin
        ]);

    }

    public function welcomeMasterApplyForm(Request $request, Etablissement $etablissement)
    {
        $cne = session('cne');
        $cin = session('cin');

        // $cne = "M123456789";
        // $cin = "D745896";

        if(!$cne || !$cin){
            return redirect()->route('welcomeMaster',['etablissement' => $etablissement->id]);
        }

        $etablissement->load(['serie_bac','diplomebacplus2']);

        $filieres = Filiere::
        where('etablissement_id',$etablissement->id)
        ->where('active',1)
        ->where('type',1)
        ->get();

        return view('front-end.master.preinscription-master-form', compact('cne', 'cin', 'etablissement','filieres'));
    }

    public function welcomeLicenceExcellence(Etablissement $etablissement){
        if($etablissement->passerelle_ouvert == 0){
            return view('front-end.licenceExcellence.preinscription-licenceExcellence-form-fermer',compact('etablissement'));
        }
        return view('front-end.licenceExcellence.welcomeLicenceExcelleneceFirstForm',compact('etablissement'));
    }

    public function welcomeLicenceExcellenceApply(Etablissement $etablissement,Request $request){

        $request->validate([
            'cne' => 'required|max:20',
            'cin' => 'required|max:10'
        ]);

        // $listeFiliereID = Filiere::
        // where('etablissement_id',$etablissement->id)
        // ->where('type',2)
        // ->pluck('id');


        // if($etablissement->multiple_choix_filiere_master){  //multiple choix
        //     $studentPasserelle = StudentPasserelle::where(function($query) use ($request) {
        //         $query->where('CNE', $request->cne)
        //               ->where('CIN', $request->cin);
        //     })
        //     ->where(function($query) use ($listeFiliereID) {
        //         $query->whereIn('filiere_choix_1', $listeFiliereID)
        //               ->orWhereIn('filiere_choix_2', $listeFiliereID)
        //               ->orWhereIn('filiere_choix_3', $listeFiliereID);
        //     })
        //     ->first();
        // }else{  // un seul choix
        //     $studentPasserelle = StudentPasserelle::where(function($query) use ($request) {
        //         $query->where('CNE', $request->cne)
        //               ->where('CIN', $request->cin);
        //     })
        //     ->whereIn('filiere',$listeFiliereID)
        //     ->first();
        // }

        // if($studentPasserelle){
        //     return back()->with('error_student_exist','vous avez déjà postulé ici');
        // }

        return redirect()->route('welcomeLicenceExcelllence.apply.form',['etablissement' => $etablissement->id])->with([
            'etablissement' => $etablissement->id,
            'cne' => $request->cne,
            'cin' => $request->cin
        ]);
    }

    public function welcomeLicenceExcellenceApplyForm(Request $request,Etablissement $etablissement){
        $cne = session('cne');
        $cin = session('cin');

        if(!$cne || !$cin){
            return redirect()->route('welcomeLicenceExcelllence',['etablissement' => $etablissement->id]);
        }

        $etablissement->load(['serie_bac','diplomebacplus2']);

        $filieres = Filiere::
        where('etablissement_id',$etablissement->id)
        ->where('active',1)
        ->where('type',2)
        ->get();

        return view('front-end.licenceExcellence.preinscription-licenceExcellenceform', compact('cne', 'cin', 'etablissement','filieres'));
    }

   public function quickpreinscription(){
    $etablissements = Etablissement::with(['filiereMaster','filiereLicence'])->get();
    return view('front-end.form-quick',compact('etablissements'));
   }

    public function nosFormation(){
        $etablissements = Etablissement::all();
        return view('front-end.nos-formation',compact('etablissements'));
    }

    public function nosFormationMaster(Etablissement $etablissement){
        $filieresMaster = Filiere::where('etablissement_id',$etablissement->id)->where('type',1)->where('active',1)->get();
        return view('front-end.nos-formation-master',compact('etablissement','filieresMaster'));
    }

    public function nosFormationLicence(Etablissement $etablissement){
        $filieresLicence = Filiere::where('etablissement_id',$etablissement->id)->where('type',2)->where('active',1)->get();
        return view('front-end.nos-formation-licence',compact('etablissement','filieresLicence'));
    }

    public function nosFormationChosisr($id){
        $filiere = Filiere::whereId($id)
        ->with('etablissement')
        ->first();
        return view('front-end.form-formation-choisen',compact('filiere'));
    }

    public function showActualite(Actualite $actualite){
        return view('front-end.showAnnonce',compact('actualite'));
    }
}
