<?php

namespace App\Http\Controllers\supAdmin;

use App\Models\User;
use App\Models\Bachelier;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class EtablissementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etablissements = Etablissement::all();
        return view('sup-admin.etablissement.index',compact('etablissements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $responsables = User::where('role_id',2)->get();  //responsables des établissements
        return view('sup-admin.etablissement.create',compact('responsables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom'                       =>  'required|max:80',
            'nom_abrev'                 =>  'required|max:20',
            'description'               =>  'required',
            'file'                      =>  'required',
            'responsable_id'            =>  'required',
        ]);

        $fileName = $request->file;
        $filePath = storage_path('tmp/uploads/') . $fileName;

        $fileExists = File::exists($filePath);

        if ($fileExists) {
            File::move(storage_path('tmp/uploads/'. basename($request->file)),public_path('files/logo_etablissement/'. basename($request->file)));
            $path = 'files/logo_etablissement/'. basename($request->file);
        } else {
            $path = null;
        }

        Etablissement::create([
            'nom'                                   => $request->nom,
            'nom_abrev'                             => $request->nom_abrev,
            'description'                           => $request->description,
            'logo'                                  => $path,
            'responsable_id'                        => $request->responsable_id,
        ]);

        return redirect()->route('sup-admin.etablissement.index')->with('message','Etablissement est crée avec succées');
    }

    /**
     * Display the specified resource.
     */
    public function show(Etablissement $etablissement)
    {
        $etablissement->load(['responsable']);
        return view('sup-admin.etablissement.show', compact('etablissement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Etablissement $etablissement)
    {
        $responsables = User::where('role_id',2)->get();
        return view('sup-admin.etablissement.edit',compact('responsables','etablissement'));
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
            'responsable_id'            =>  'required',
        ]);

        $etablissement->update([
            'nom'                    => $request->nom,
            'nom_abrev'              => $request->nom_abrev,
            'description'            => $request->description,
            'responsable_id'         => $request->responsable_id,
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
        return redirect()->route('sup-admin.etablissement.index')->with('message','Etablissement est modifié avec succées');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function togglePreInscription(Request $request){
        $etablissement = Etablissement::whereId($request->id)->first();
        switch ($request->type) {
            case 'passerelle':
                $etablissement->passerelle_ouvert = !$etablissement->passerelle_ouvert;
                    StudentPasserelle::where('etablissement_id', $etablissement->id)
                        ->update(['confirmation_student' => 1]);
                break;
            case 'master':
                $etablissement->master_ouvert = !$etablissement->master_ouvert;
                    StudentMaster::where('etablissement_id', $etablissement->id)
                        ->update(['confirmation_student' => 1]);
                break;
            case 'bachelier':
                $etablissement->bachelier_ouvert = !$etablissement->bachelier_ouvert;
                    Bachelier::where('etablissement_id', $etablissement->id)
                        ->update(['confirmation_student' => 1]);
                break;
            default:
                return response()->json(['message' => 'Type invalide'], 400);
        }
        $etablissement->save();
        return response()->json(['message' => 'Votre action est faites avec succées']);
        return $request->all();
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
