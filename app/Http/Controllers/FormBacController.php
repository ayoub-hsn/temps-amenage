<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Filiere;
use App\Models\Province;
use App\Models\SerieBac;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use Illuminate\Support\Facades\Hash;
use App\Models\StudentBacAccesOuvert;
use App\Http\Requests\EtudiantBacAcceeOuvertRequest;

class FormBacController extends Controller
{
    public function bacheliersAcceOuvertShowForm(Etablissement $etablissement,Request $request){
        if(!$etablissement->bac_accee_ouvert_ouvert){
            return view('front-end.bachelier.preinscription-acceouvert-form-fermer',compact('etablissement'));
        }
        $provinces = Province::all();
        return view('front-end.bachelier.welcomeBachelierAccetOuvertFirstForm',compact('provinces','etablissement'));
    }

    public function bacheliersAcceOuvertFormApply(Etablissement $etablissement,Request $request){
        $request->validate([
            'cin' => 'required|max:10',
            'datenais' => 'required',
            'province' => 'required'
        ]);


        $province = $request->province;
        $CIN = $request->cin;
        $datenais = $request->datenais;
        $birthDate = Carbon::parse($request->datenais);
        $age = $birthDate->age;


        $filieres = Filiere::where('etablissement_id', $etablissement->id)
        ->where('type', 3)
        ->where('accee_ouvert', 1)
        ->where('active', 1)
        ->where(function ($query) use ($province) {
            $query->whereHas('provinces', function ($q) use ($province) {
                $q->where('provinces.id', $province);
            })->orWhereDoesntHave('provinces');
        })
        ->where(function ($q) use ($age) {
            $q->whereNull('max_age')
              ->orWhere('max_age', '>=', $age);
        })
        ->get();

        return view('front-end.bachelier.filieres',compact('etablissement','filieres','province','CIN','datenais'));
    }

    public function bacheliersAcceOuvertFormApplyFinal(Etablissement $etablissement,Request $request){
        // return $request->all();
        $filiere = Filiere::whereId($request->filiere_id)->first();
        $CIN = $request->CIN;
        $datenais = $request->datenais;
        $province = $request->province;
        $etablissement->load(['serie_bac']);

        return view('front-end.bachelier.preinscription-acceouvertForm',compact('etablissement','filiere','CIN','datenais','province'));
    }

    public function submitFormBacAcceeOuvert(EtudiantBacAcceeOuvertRequest $request){
        $serie_bac = SerieBac::whereId($request->serie)->first();

        $request['serie'] = $serie_bac->nom ?? $request->serie;
        $request['verif'] = "EN COURS";
        $request['confirmation_student'] = 0;
        
        if($request->handicap == "non"){
            $request['handicap'] = 0;
        }else{
            $request['handicap'] = 1;
        }
        if($request->fonctionnaire == "NON"){
            $request['fonctionnaire'] = 0;
        }else{
            $request['fonctionnaire'] = 1;
        }

        $data = $request->all();

        if ($request->hasFile('path_photo')) {
            $data['path_photo'] = $this->saveFileBacAcceeOuvert($request->file('path_photo'), $request->CIN.'-PHOTO.jpg');
        }

        if ($request->hasFile('path_cin')) {
            $data['path_cin'] = $this->saveFileBacAcceeOuvert($request->file('path_bac'), $request->CIN.'-CIN.jpg');
        }

        if ($request->hasFile('path_bac')) {
            $data['path_bac'] = $this->saveFileBacAcceeOuvert($request->file('path_bac'), $request->CIN.'-CIN.jpg');
        }

        if ($request->hasFile('path_cv')) {
            $data['path_cv'] = $this->saveFileBacAcceeOuvert($request->file('path_cv'), $request->CIN.'-CV.pdf');
        }
        
        $data['user_id'] = $this->createUserForm($data);
        $studentBacAcceeOuvert = $this->createstudentBacAcceeOuvert($data);
        if($studentBacAcceeOuvert){
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
                'password' => Hash::make($data['CIN'].'-'.$data['nom'].'-'.$data['prenom']),
                'role_id' => 4,
                'active' => 1
            ]);
            return $user->id;
        }
    }

    public function createstudentBacAcceeOuvert($data){
        $studentBacAcceeOuvert = StudentBacAccesOuvert::create($data);
        return $studentBacAcceeOuvert;
    }

    private function saveFileBacAcceeOuvert($file, $filename)
    {
        $destinationPath = public_path('uploads/bac/accee_ouvert');
        $file->move($destinationPath, $filename);

        return 'uploads/bac/accee_ouvert/' . $filename;
    }
}
