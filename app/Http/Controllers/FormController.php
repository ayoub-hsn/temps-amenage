<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Filiere;
use App\Models\SerieBac;
use App\Models\DiplomBac2;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EtudiantMasterRequest;
use App\Http\Requests\EtudiantLicenceExcellenceRequest;

class FormController extends Controller
{
    public function submitFormMaster(EtudiantMasterRequest $request){

        // $studentMaster = StudentMaster::where(function($query) use ($request) {
        //         $query->where('CNE', $request->CNE)
        //               ->where('CIN', $request->CIN);
        //     })
        //     ->where('etablissement_id',$request->etablissement_id)
        //     ->first();
        // if ($studentMaster) {
        //     return back()->withInput()->withErrors([
        //         'CNE' => 'Vous avez déjà postulé avec ce CNE ou CIN.',
        //     ]);
        // }

        $serie_bac = SerieBac::whereId($request->serie)->first();
        $request['serie'] = $serie_bac->nom ?? $request->serie;
        // $request['diplomedeug'] = $diplomedeug->nom ?? $request->diplomedeug;
        $request['verif'] = "EN COURS";
        $request['confirmation_student'] = 0;

        if($request->fonctionnaire == "NON"){
            $request['fonctionnaire'] = 0;
        }else{
            $request['fonctionnaire'] = 1;
        }

        $data = $request->all();

        if ($request->hasFile('path_photo')) {
            $data['path_photo'] = $this->saveFileMaster($request->file('path_photo'), $request->CIN.'-PHOTO.jpg');
        }

        if ($request->hasFile('path_cin')) {
            $data['path_cin'] = $this->saveFileMaster($request->file('path_cin'), $request->CIN.'-CIN.jpg');
        }

        if ($request->hasFile('path_bac')) {
            $data['path_bac'] = $this->saveFileMaster($request->file('path_bac'), $request->CIN.'-BAC.jpg');
        }

        if ($request->hasFile('path_licence')) {
            $data['path_licence'] = $this->saveFileMaster($request->file('path_licence'), $request->CIN.'-LICENCE.jpg');
        }

        if ($request->hasFile('path_note1')) {
            $data['path_note1'] = $this->saveFileMaster($request->file('path_note1'), $request->CIN.'-S1.jpg');
        }

        if ($request->hasFile('path_attestation_non_emploi')) {
            $data['path_attestation_non_emploi'] = $this->saveFileMaster($request->file('path_attestation_non_emploi'), $request->CIN.'-ATTESTATIONNONEMPLOI.jpg');
        }

        if ($request->hasFile('path_cv')) {
            $data['path_cv'] = $this->saveFileMaster($request->file('path_cv'), $request->CIN.'-CV.pdf');
        }




        $data['user_id'] = $this->createUserForm($data);
        $studentMaster = $this->createStudentMaster($data);
        if($studentMaster){
            return response()->json([
                'status' => 1,
            ]);
        }else{
            return response()->json([
                'status' => 0
            ]);
        }
    }

    public function submitFormLicenceExcellence(EtudiantLicenceExcellenceRequest $request){
        // $studentPasserelle = StudentPasserelle::where(function($query) use ($request) {
        //     $query->where('CNE', $request->CNE)
        //         ->where('CIN', $request->CIN);
        // })
        // ->where('etablissement_id', $request->etablissement_id)
        // ->first();

        // if ($studentPasserelle) {
        //     return back()->withInput()->withErrors([
        //         'CNE' => 'Vous avez déjà postulé avec ce CNE ou CIN.',
        //     ]);
        // }

        $serie_bac = SerieBac::whereId($request->serie)->first();
        // $diplomedeug = DiplomBac2::whereId($request->diplomedeug)->first();
        $request['serie'] = $serie_bac->nom ?? $request->serie;
        // $request['diplomedeug'] = $diplomedeug->nom ?? $request->diplomedeug;
        $request['verif'] = "EN COURS";
        $request['confirmation_student'] = 0;


        if($request->fonctionnaire == "NON"){
            $request['fonctionnaire'] = 0;
        }else{
            $request['fonctionnaire'] = 1;
        }

        $data = $request->all();

        if ($request->hasFile('path_photo')) {
            $data['path_photo'] = $this->saveFilePasserelle($request->file('path_photo'), $request->CIN.'-PHOTO.jpg');
        }

        if ($request->hasFile('path_cin')) {
            $data['path_cin'] = $this->saveFilePasserelle($request->file('path_cin'), $request->CIN.'-CIN.jpg');
        }

        if ($request->hasFile('path_bac')) {
            $data['path_bac'] = $this->saveFilePasserelle($request->file('path_bac'), $request->CIN.'-BAC.jpg');
        }

        if ($request->hasFile('path_diplomedeug')) {
            $data['path_diplomedeug'] = $this->saveFilePasserelle($request->file('path_diplomedeug'), $request->CIN.'-DEUG.jpg');
        }

        if ($request->hasFile('path_attestation_non_emploi')) {
            $data['path_attestation_non_emploi'] = $this->saveFilePasserelle($request->file('path_attestation_non_emploi'), $request->CIN.'-ATTESTATIONNONEMPLOI.jpg');
        }

        if ($request->hasFile('path_cv')) {
            $data['path_cv'] = $this->saveFilePasserelle($request->file('path_cv'), $request->CIN.'-CV.pdf');
        }

        $data['user_id'] = $this->createUserForm($data);
        $studentPasserelle = $this->createStudentPasserelle($data);
        if($studentPasserelle){
            return response()->json([
                'status' => 1,
            ]);
        }else{
            return response()->json([
                'status' => 0
            ]);
        }
    }

    private function createUserForm($data){
        $user = User::where('email',$data['email'])->first();
        if($user){
            return $user->id;
        }else{
            $user = User::create([
                'name' => $data['nom'].' '.$data['prenom'],
                'telephone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['CIN'].'@2025'),
                'role_id' => 4,
                'active' => 1
            ]);
            return $user->id;
        }
    }

    public function createStudentMaster($data){
        $studentMaster = StudentMaster::create($data);
        return $studentMaster;
    }

    public function createStudentPasserelle($data){
        $studentPasserelle = StudentPasserelle::create($data);
        return $studentPasserelle;
    }

    private function saveFileMaster($file, $filename)
    {
        $destinationPath = public_path('uploads/master');
        $file->move($destinationPath, $filename);

        return 'uploads/master/' . $filename;
    }

    private function saveFilePasserelle($file, $filename){
        $destinationPath = public_path('uploads/passerelle');
        $file->move($destinationPath, $filename);

        return 'uploads/passerelle/' . $filename;
    }



    public function createUserFormQuick($data){

        $user = User::where('email',$data['email'])->first();
        if($user){
            return [
                'user_id' => $user->id,
                'exists'  => true,
            ];
        }else{
            $user = User::create([
                'name' => $data['nom'].' '.$data['prenom'],
                'telephone' => $data['phone'],
                'email' => $data['email'],
                'password' => Hash::make($data['CIN'].'@2025'),
                'role_id' => 4,
                'active' => 1
            ]);
            return [
                'user_id' => $user->id,
                'exists'  => false,
            ];
        }
    }


    public function submitFormQuick(Request $request){

        // return response()->json($user);
        $request->validate([
            'CIN' => 'required|min:3|max:10',
            'nom' => 'required|min:2|max:50',
            'prenom' => 'required|min:2|max:50',
            'dernier_diplome_obtenu' => 'required',
            'type_diplome_obtenu' => 'required|min:2|max:200',
            'specialitediplome' => 'required|min:2|max:200',
            'ville_etablissement_diplome' => 'required|min:2|max:150',
        ]);

        $filiere = Filiere::whereId($request->filiere_id)->first();
        $data = $request->all();
        if($request->programme == "licence"){
            $user = $this->createUserFormQuick($data);
            $studentpasserelle = StudentPasserelle::create([
                'CIN'                           => $request->CIN,
                'nom'                           => $request->nom,
                'prenom'                        => $request->prenom,
                'email'                         => $request->email,
                'phone'                         => $request->phone,
                'dernier_diplome_obtenu'        => $request->dernier_diplome_obtenu,
                'type_diplome_obtenu'           => $request->type_diplome_obtenu,
                'specialitediplome'             => $request->specialitediplome,
                'ville_etablissement_diplome'   => $request->ville_etablissement_diplome,
                'filiere'                       => (int)$request->filiere_id,
                'user_id'                       => (int)$user['user_id'],
                'etablissement_id'              => $filiere->etablissement_id,
                'verif'                         => "EN COURS",
                'confirmation_student'          => 0
            ]);
            if($studentpasserelle){
                return response()->json([
                    'status' => 1,
                    'message' => "Votr candidatue est envoyé avec succées ",
                    'user'    => $user
                ]);
            }else{
                return response()->json([
                    'status' => 0,
                    'message' => "There is a probelm lors insertion refiare aprés"
                ]);
            }
        }elseif($request->programme == "master"){
            $user = $this->createUserFormQuick($data);
            $studentMaster = StudentMaster::create([
                'CIN'                           => $request->CIN,
                'nom'                           => $request->nom,
                'prenom'                        => $request->prenom,
                'email'                         => $request->email,
                'phone'                         => $request->phone,
                'dernier_diplome_obtenu'        => $request->dernier_diplome_obtenu,
                'type_diplome_obtenu'           => $request->type_diplome_obtenu,
                'specialitediplome'             => $request->specialitediplome,
                'ville_etablissement_diplome'   => $request->ville_etablissement_diplome,
                'filiere'                       => (int)$request->filiere_id,
                'user_id'                       => (int)$user['user_id'],
                'etablissement_id'              => $filiere->etablissement_id,
                'verif'                         => "EN COURS",
                'confirmation_student'          => 0
            ]);
            if ($studentMaster) {
                return response()->json([
                    'status' => 1,
                    'message' => "Votr candidatue est envoyé avec succées ",
                    'user'    => $user
                ]);
            } else{
                return response()->json([
                    'status' => 0,
                    'message' => "There is a probelm lors insertion refiare aprés"
                ]);
            }

        }else{
            return response()->json([
                'status' => 0,
                'message' => "Veuillez choisir un programme correcte"
            ]);
        }

    }








    // StudentMaster::create([
        //     'CNE'                           => $data->CNE,
        //     'CIN'                           => $data->CIN,
        //     'nom'                           => $data->nom,
        //     'prenom'                        => $data->prenom,
        //     'nomar'                         => $data->nomar,
        //     'prenomar'                      => $data->prenomar,
        //     'datenais'                      => $data->datenais,
        //     'sexe'                          => $data->sexe,
        //     'payschamp'                     => $data->payschamp,
        //     'villenais'                     => $data->villenais,
        //     'villechamp'                    => $data->villechamp,
        //     'adresse'                       => $data->adresse,
        //     'email'                         => $data->email,
        //     'phone'                         => $data->phone,
        //     'handicap'                      => $data->handicap,
        //     'CINpere'                       => $data->CINpere,
        //     'nompere'                       => $data->nompere,
        //     'prenompere'                    => $data->prenompere,
        //     'metierpere'                    => $data->metierpere,
        //     'CINmere'                       => $data->CINmere,
        //     'nommere'                       => $data->nommere,
        //     'prenommere'                    => $data->prenommere,
        //     'metiermere'                    => $data->metiermere,


        //     'serie'                         => $data->serie,
        //     'Anneebac'                      => $data->Anneebac,
        //     'notebac'                       => $data->notebac,
        //     'mention_bac'                   => $data->mention_bac,
        //     'diplomedeug'                   => $data->diplomedeug,
        //     'mentiondeug'                   => $data->mentiondeug,
        //     'specialitedeug'                => $data->specialitedeug,
        //     'etblsmtdeug'                   => $data->etblsmtdeug,
        //     'ville_etablissement_deug'      => $data->ville_etablissement_deug,
        //     'date_obtention_deug'           => $data->date_obtention_deug,
        //     'typelicence'                   => $data->typelicence,
        //     'mentionlp'                     => $data->mentionlp,
        //     'specialitelp'                  => $data->specialitelp,
        //     'etblsmtLp'                     => $data->etblsmtLp,
        //     'ville_etablissement_licence'   => $data->ville_etablissement_licence,
        //     'date_obtention_LP'             => $data->date_obtention_LP,
        //     'nombreJourStage'               => $data->nombreJourStage,
        //     'fonctionnaire'                 => $data->fonctionnaire,
        //     'secteur'                       => $data->,
        //     'nombreannee'                   => $data->,
        //     'poste'                         => $data->,
        //     'lieutravail'                   => $data->,
        //     'villetravail'                  => $data->,
        //     'notes1'                        => $data->,
        //     'notes2'                        => $data->,
        //     'notes3'                        => $data->,
        //     'notes4'                        => $data->,
        //     'notes5'                        => $data->,
        //     'notes6',


        //     'path_note1'                    => ,
        //     'path_note2'                    => ,
        //     'path_note3'                    => ,
        //     'path_note4'                    => ,
        //     'path_note5'                    => ,
        //     'path_note6'                    => ,



        //     'filiere'                       =>,
        //     'filiere_choix_1'               =>,
        //     'filiere_choix_2'               =>,
        //     'filiere_choix_3'               =>,


        //     'user_id'                       => $data->user_id
        // ]);
}
