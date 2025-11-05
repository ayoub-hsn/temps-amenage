<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Filiere;
use App\Models\SerieBac;
use App\Models\Bachelier;
use App\Models\DiplomBac2;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\EtudiantMasterRequest;
use App\Http\Requests\EtudiantBachelierRequest;
use App\Http\Requests\EtudiantLicenceExcellenceRequest;

class FormController extends Controller
{
    public function submitFormMaster(EtudiantMasterRequest $request){

        $stdMaster = StudentMaster::where('filiere', $request->filiere)
        ->where(function ($query) use ($request) {
            $query->where('CIN', $request->CIN)
                ->orWhere('email', $request->email);
        })
        ->first();

        if($stdMaster){
            return response()->json([
                'status' => 2,
                'message' => "Vous avez déjà soumis une candidature pour cette filière"
            ]);
        }

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


        $user = $this->createUserFormQuick($data);

        $data['user_id'] = (int)$user['user_id'];
        $studentMaster = $this->createStudentMaster($data);

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
       
    }

    public function submitFormLicenceExcellence(EtudiantLicenceExcellenceRequest $request){
     
        $stdPasserelle = StudentPasserelle::where('filiere', $request->filiere)
        ->where(function ($query) use ($request) {
            $query->where('CIN', $request->CIN)
                ->orWhere('email', $request->email);
        })
        ->first();

        if($stdPasserelle){
            return response()->json([
                'status' => 2,
                'message' => "Vous avez déjà soumis une candidature pour cette filière"
            ]);
        }

        $serie_bac = SerieBac::whereId($request->serie)->first();
        $diplomedeug = DiplomBac2::whereId($request->diplomedeug)->first();
        $request['serie'] = $serie_bac->nom ?? $request->serie;
        $request['diplomedeug'] = $diplomedeug->nom ?? $request->diplomedeug;
        $request['verif'] = "EN COURS";
        $request['confirmation_student'] = 0;


        if($request->fonctionnaire == "NON"){
            $request['fonctionnaire'] = 0;
        }else{
            $request['fonctionnaire'] = 1;
        }

        $data = $request->all();

        

        $user = $this->createUserFormQuick($data);
        $data['user_id'] = (int)$user['user_id'];
        $studentPasserelle = $this->createStudentPasserelle($data);
        if ($studentPasserelle) {
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
    }

    public function submitFormBachelier(EtudiantBachelierRequest $request){
     
        $stdBachelier = Bachelier::where('filiere', $request->filiere)
        ->where(function ($query) use ($request) {
            $query->where('CIN', $request->CIN)
                ->orWhere('email', $request->email);
        })
        ->first();

        if($stdBachelier){
            return response()->json([
                'status' => 2,
                'message' => "Vous avez déjà soumis une candidature pour cette filière"
            ]);
        }

        $serie_bac = SerieBac::whereId($request->serie)->first();
       
        $request['serie'] = $serie_bac->nom ?? $request->serie;
        $request['verif'] = "EN COURS";
        $request['confirmation_student'] = 0;
        

        $data = $request->all();

        

        $user = $this->createUserFormQuick($data);
        $data['user_id'] = (int)$user['user_id'];
        $studentBachelier = $this->createStudentBachelier($data);
        if ($studentBachelier) {
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

    public function createStudentMaster($data){
        $studentMaster = StudentMaster::create($data);
        return $studentMaster;
    }

    public function createStudentPasserelle($data){
        $studentPasserelle = StudentPasserelle::create($data);
        return $studentPasserelle;
    }

    public function createStudentBachelier($data){
        $studentBachelier = Bachelier::create($data);
        return $studentBachelier;
    }


   


  




}
