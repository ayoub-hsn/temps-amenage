<?php

namespace App\Http\Controllers\adminEtab;

use App\Models\SerieBac;
use App\Models\DiplomBac2;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function edit()
    {
        $etablissement = Etablissement::where('responsable_id',Auth::id())
        ->with(['serie_bac','diplomebacplus2'])
        ->first();

        $serieBac = SerieBac::all();
        $diplomeBacplus2 = DiplomBac2::all();

        return view('admin-etab.etablissement.parametre',compact('etablissement','serieBac','diplomeBacplus2'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Etablissement $etablissement)
    {
        $request->validate([
            'nom'                       =>  'required|max:80',
            'nom_abrev'                 =>  'required|max:20',
            'description'               =>  'required',
        ]);

        $etablissement->update([
            'nom'                    => $request->nom,
            'nom_abrev'              => $request->nom_abrev,
            'description'            => $request->description,
        ]);


        $fileName = $request->file;

        if($fileName){
            $filePath = public_path($etablissement->logo);
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $filePath = storage_path('tmp/uploads/') . $fileName;

            $fileExists = File::exists($filePath);

            if ($fileExists) {
                File::move(storage_path('tmp/uploads/'. basename($request->file)),public_path('files/logo_etablissement/'. basename($request->file)));
                $path = 'files/logo_etablissement/'. basename($request->file);
            } else {
                $path = null;
            }
            $etablissement->update([
                'logo' => $path,
            ]);
        }
        return back()->with('message',"Parametre d'établissement est modifié avec succées");
    }

    public function updateParametreMaster(Request $request,Etablissement $etablissement){
        $request['master_ouvert'] = (int)$request->master_ouvert;
        if($request->show_cin_input_master){
            $request['show_cin_input_master'] = 1;
        }else{
            $request['show_cin_input_master'] = 0;
        }
        if($request->show_photo_input_master){
            $request['show_photo_input_master'] = 1;
        }else{
            $request['show_photo_input_master'] = 0;
        }
        if($request->show_cv_input_master){
            $request['show_cv_input_master'] = 1;
        }else{
            $request['show_cv_input_master'] = 0;
        }

        if($request->show_bac_input_master){
            $request['show_bac_input_master'] = 1;
        }else{
            $request['show_bac_input_master'] = 0;
        }

        if($request->show_licence_input_master){
            $request['show_licence_input_master'] = 1;
        }else{
            $request['show_licence_input_master'] = 0;
        }

        if($request->show_attestation_no_emploi_input_master){
            $request['show_attestation_no_emploi_input_master'] = 1;
        }else{
            $request['show_attestation_no_emploi_input_master'] = 0;
        }

        if($request->multiple_choix_filiere_master){
            $request['multiple_choix_filiere_master'] = 1;
        }else{
            $request['multiple_choix_filiere_master'] = 0;
        }

        $etablissement->update($request->all());

        if ($etablissement->master_ouvert == 0) {
            StudentMaster::where('etablissement_id', $etablissement->id)
                        ->update(['confirmation_student' => 1]);
        }

        return back()->with('message',"Parametre du master est modifié avec succées");
    }

    public function updateParametrePasserelle(Request $request,Etablissement $etablissement){
        $request['passerelle_ouvert'] = (int)$request->passerelle_ouvert;
        $request['show_cin_input_passerelle'] = (int)$request->show_cin_input_passerelle;
        $request['show_photo_input_passerelle'] = (int)$request->show_photo_input_passerelle;
        $request['show_cv_input_passerelle'] = (int)$request->show_cv_input_passerelle;
        $request['show_bac_input_passerelle'] = (int)$request->show_bac_input_passerelle;
        $request['show_diplome_deug_input_passerelle'] = (int)$request->show_diplome_deug_input_passerelle;
        $request['show_attestation_no_emploi_input_passerelle'] = (int)$request->show_attestation_no_emploi_input_passerelle;

        $etablissement->update($request->all());

        if ($etablissement->passerelle_ouvert == 0) {
            StudentPasserelle::where('etablissement_id', $etablissement->id)
                        ->update(['confirmation_student' => 1]);
        }

        return back()->with('message',"Parametre de la Licence est modifié avec succées");
    }

    public function updateParametreDiplomeBac(Request $request,Etablissement $etablissement){
        $etablissement->serie_bac()->sync($request->input('serie_bac'));
        return back()->with('message','Vous avez modifié les séries du Bac à afficher avec succès.');
    }

    public function updateParametreDiplomeBacPlus2(Request $request,Etablissement $etablissement){
        $etablissement->diplomebacplus2()->sync($request->input('diplome_bac2'));
        return back()->with('message','Vous avez modifié les diplomes à afficher avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function storeMedia(Request $request){
        // Validates file size
        if (request()->has('size')) {
            $this->validate(request(), [
                'file' => 'max:' . request()->input('size') * 1024,
            ]);
        }

        // If width or height is preset - we are validating it as an image
        if (request()->has('width') || request()->has('height')) {
            $this->validate(request(), [
                'file' => sprintf(
                    'image|dimensions:max_width=%s,max_height=%s',
                    request()->input('width', 1),
                    request()->input('height', 1)
                ),
            ]);
        }

        $path = storage_path('tmp'.DIRECTORY_SEPARATOR.'uploads');

        try {
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        } catch (\Exception $e) {
        }

        $file = $request->file('file');

        $name = time() .'.' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }
}
