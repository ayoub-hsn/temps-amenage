<?php

namespace App\Http\Controllers\adminEtab;

use App\Models\User;
use App\Models\Filiere;
use App\Models\Province;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentMasterExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\StudentBacAccesOuvert;
use App\Exports\StudentPasserelleExport;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etablissement = Etablissement::where('responsable_id',Auth::id())->first();
        // $filieres = Filiere::where('etablissement_id',($etablissement->id ?? 0))->withCount('')->get();
        return view('admin-etab.filiere.index',compact('filieres'));
    }

    public function indexLicenceAcceOuvert(){

        $etablissement = Etablissement::where('responsable_id',Auth::id())->first();
        $filieres = Filiere::where('etablissement_id',$etablissement->id)
        ->where('type',3)
        ->where('accee_ouvert',1)
        ->with('responsable')
        ->withCount(['licenceAcceOuvertStudents'])
        ->get();

        return view('admin-etab.filiere.indexLicenceAcceOuvert',compact('filieres'));
    }


    public function indexLicenceExcellence(){
        $etablissement = Etablissement::where('responsable_id',Auth::id())->first();
        $filieres = DB::table('filieres')
        ->select('filieres.*', 'users.name as responsable') // Get the name of the responsible person
        ->leftJoin('student_passerelles', function ($join) {
            if (auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_passerelle == 1) {
                $join->on('student_passerelles.filiere_choix_1', '=', 'filieres.id')
                     ->orOn('student_passerelles.filiere_choix_2', '=', 'filieres.id')
                     ->orOn('student_passerelles.filiere_choix_3', '=', 'filieres.id');
            } else {
                $join->on('student_passerelles.filiere', '=', 'filieres.id');
            }
        })
        ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id') // Join users table to get responsable name
        ->where('filieres.etablissement_id', $etablissement->id)
        ->where('filieres.type', 2)
        ->groupBy('filieres.id', 'users.name') // Add users.name to group by
        ->selectRaw('COUNT(student_passerelles.id) as students_count')
        ->get();

        return view('admin-etab.filiere.indexLicencExcellence',compact('etablissement','filieres'));
    }

    public function indexMaster()
    {
        $etablissement = Etablissement::where('responsable_id', Auth::id())->first();

        // Retrieve filieres with responsible relation
        $filieres = DB::table('filieres')
        ->select('filieres.*', 'users.name as responsable') // Get the name of the responsible person
        ->leftJoin('student_masters', function ($join) {
            if (auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_master == 1) {
                $join->on('student_masters.filiere_choix_1', '=', 'filieres.id')
                     ->orOn('student_masters.filiere_choix_2', '=', 'filieres.id')
                     ->orOn('student_masters.filiere_choix_3', '=', 'filieres.id');
            } else {
                $join->on('student_masters.filiere', '=', 'filieres.id');
            }
        })
        ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id') // Join users table to get responsable name
        ->where('filieres.etablissement_id', $etablissement->id)
        ->where('filieres.type', 1)
        ->groupBy('filieres.id', 'users.name') // Add users.name to group by
        ->selectRaw('COUNT(student_masters.id) as students_count')
        ->get();


        return view('admin-etab.filiere.indexMaster', compact('etablissement','filieres'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $res1 = Filiere::where('etablissement_id', auth()->user()->etablissement->id)
        ->with('responsable') // eager load the responsible user
        ->get()
        ->pluck('responsable') // get only responsables
        ->unique('id') // avoid duplicates
        ->values();

        $res2 = User::where('role_id',3)->where('created_by',Auth::id())->get();

        // Merge and remove duplicates by 'id'
        $responsables = $res1->merge($res2)->unique('id')->values();


        return view('admin-etab.filiere.create',compact('responsables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $etablissement = Etablissement::where('responsable_id',Auth::id())->first();
        $request['etablissement_id'] = $etablissement->id ?? null;
        $request['active'] = 1;

        $request->validate([
            'nom_abrv'          => 'required|max:10',
            'nom_complet'       => 'required|max:250',
            'description'       => 'required',
            'etablissement_id'  => 'required',
            'responsable_id'    => 'required',
            'type'              => 'required',
            'active'            => 'required'
        ]);
        if ($request->hasFile('file')) {
            $fileName = $request->file;
            $filePath = storage_path('tmp/uploads/') . $fileName;

            $fileExists = File::exists($filePath);

            if ($fileExists) {
                File::move(storage_path('tmp/uploads/'. basename($request->file)),public_path('files/filiere_docs/'. basename($request->file)));
                $request['document'] = 'files/filiere_docs/'. basename($request->file);
            } else {
                $request['document'] = null;
            }
        }else{
            $request['document'] = null;
        }

        Filiere::create($request->all());

        switch ($request->type) {
            case 1:
                return redirect()->route('admin-etab.filiere.master.index')->with('message','Filiere est ajouté avec succée');
                break;
            case 2:
                return redirect()->route('admin-etab.filiere.licencexcellence.index')->with('message','Filiere est ajouté avec succée');
                break;
            case 3:
                if($request->accee_ouvert == 1){
                    return redirect()->route('admin-etab.filiere.licence.acceeouvert.index')->with('message','Filiere est ajouté avec succée');
                }else{
                    return redirect()->route('admin-etab.filiere.licence.acceeregule.index')->with('message','Filiere est ajouté avec succée');
                }
                break;
            default:
                return redirect()->route('admin-etab.filiere.licencexcellence.index')->with('message','Filiere est ajouté avec succée');
                break;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Filiere $filiere)
    {
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Filiere $filiere)
    {
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }

        $res1 = Filiere::where('etablissement_id', auth()->user()->etablissement->id)
        ->with('responsable') // eager load the responsible user
        ->get()
        ->pluck('responsable') // get only responsables
        ->unique('id') // avoid duplicates
        ->values();

        $res2 = User::where('role_id',3)->where('created_by',Auth::id())->get();

        // Merge and remove duplicates by 'id'
        $responsables = $res1->merge($res2)->unique('id')->values();

        return view('admin-etab.filiere.edit',compact('responsables','filiere'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Filiere $filiere)
    {
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        $request->validate([
            'nom_abrv'          => 'required|max:10',
            'nom_complet'       => 'required|max:250',
            'description'       => 'required',
            'responsable_id'    => 'required',
            'type'              => 'required',
        ]);

        if($request->file){
            $fileName = $request->file;
            $filePath = storage_path('tmp/uploads/') . $fileName;

            $fileExists = File::exists($filePath);

            if ($fileExists) {
                File::move(storage_path('tmp/uploads/'. basename($request->file)),public_path('files/filiere_docs/'. basename($request->file)));
                $request['document'] = 'files/filiere_docs/'. basename($request->file);
            } else {
                $request['document'] = null;
            }
        }

        $filiere->update($request->all());

        switch ($request->type) {
            case 1:
                return redirect()->route('admin-etab.filiere.master.index')->with('message','Filiere est modifié avec succée');
                break;
            case 2:
                return redirect()->route('admin-etab.filiere.licencexcellence.index')->with('message','Filiere est modifié avec succée');
                break;
            default:
                return redirect()->route('admin-etab.filiere.licencexcellence.index')->with('message','Filiere est modifié avec succée');
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showStudentsMaster (Filiere $filiere,Request $request){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        // return $filiere->load('masterStudents');
        // return $query = StudentMaster::where('filiere',$filiere->id)->with(['filiereMaster'])->get();
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        if ($request->ajax()) {

            if($filiere->etablissement->multiple_choix_filiere_master){
                $query = StudentMaster::where('filiere_choix_1',$filiere->id)
                ->orWhere('filiere_choix_2',$filiere->id)
                ->orWhere('filiere_choix_3',$filiere->id);
            }else{
                $query = StudentMaster::where('filiere',$filiere->id);
            }

            // Apply search filters if any
            if ($request->filled('search.value')) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', "%$search%")
                    ->orWhere('prenom', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('CIN', 'like', "%$search%")
                    ->orWhere('dernier_diplome_obtenu', 'like', "%$search%")
                    ->orWhere('type_diplome_obtenu', 'like', "%$search%")
                    ->orWhere('specialitediplome', 'like', "%$search%")
                    ->orWhere('verif', 'like', "%$search%");
                });
            }

            $query->inRandomOrder();

            // Paginate the query based on the requested page
            $perPage = $request->input('length', 10); // Number of items per page
            $page = $request->input('start', 0) / $perPage + 1; // Current page number
            $data = $query->paginate($perPage, ['*'], 'page', $page);

            // Transform the data to include actions and related model attributes
            $transformedData = $data->map(function ($etudiant) use($filiere){
                // Determine the badge class based on 'verif' status
                $badgeClass = match ($etudiant->verif) {
                    'EN COURS'   => 'badge bg-warning text-white',
                    'REJETER'    => 'badge bg-danger text-white',
                    'VERIFIER'   => 'badge bg-success text-white',
                    default      => 'badge bg-secondary',
                };

                return [
                    'id'            => $etudiant->id,
                    'nom'           => $etudiant->nom,
                    'prenom'        => $etudiant->prenom,
                    'CIN'           => $etudiant->CIN,
                    'email'         => $etudiant->email,
                    'phone'         => $etudiant->phone,
                    'dernier_diplome_obtenu'   => $etudiant->dernier_diplome_obtenu,
                    'type_diplome_obtenu'   => $etudiant->type_diplome_obtenu,
                    'specialitediplome'   => $etudiant->specialitediplome,
                    'ville_etablissement_diplome'   => $etudiant->ville_etablissement_diplome,
                    'verif'         => '<span class="' . $badgeClass . '">' . $etudiant->verif . '</span>',
                    'actions' => '<a href="'.route('admin-etab.filiere.master.etudiants.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('admin-etab.etudiant.indexMasterStudents',compact('etablissement','filiere'));
    }

    public function downloadStudentsMaster(Filiere $filiere){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $multipleChoixFiliereMaster = auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_master == 1;

        $etudiants = DB::table('student_masters')
            ->select('student_masters.*',
                DB::raw($multipleChoixFiliereMaster ?
                    "filiere1.nom_complet AS filiere_choix_1_name,
                    filiere2.nom_complet AS filiere_choix_2_name,
                    filiere3.nom_complet AS filiere_choix_3_name"
                    :
                    "filiere.nom_complet AS filiere_name"
                )
            )
            ->leftJoin('filieres AS filiere1', 'student_masters.filiere_choix_1', '=', 'filiere1.id')
            ->leftJoin('filieres AS filiere2', 'student_masters.filiere_choix_2', '=', 'filiere2.id')
            ->leftJoin('filieres AS filiere3', 'student_masters.filiere_choix_3', '=', 'filiere3.id')
            ->leftJoin('filieres AS filiere', 'student_masters.filiere', '=', 'filiere.id')
            ->where(function ($query) use ($filiere, $multipleChoixFiliereMaster) {
                if ($multipleChoixFiliereMaster) {
                    $query->where('filiere1.id', $filiere->id)
                        ->orWhere('filiere2.id', $filiere->id)
                        ->orWhere('filiere3.id', $filiere->id);
                } else {
                    $query->where('student_masters.filiere', $filiere->id);
                }
            })
            ->where(function ($query) use ($multipleChoixFiliereMaster) {
                if ($multipleChoixFiliereMaster) {
                    // Exclude students where all filiere choices are NULL
                    $query->whereNotNull('student_masters.filiere_choix_1')
                        ->orWhereNotNull('student_masters.filiere_choix_2')
                        ->orWhereNotNull('student_masters.filiere_choix_3');
                } else {
                    // Exclude students with NULL filiere in single-choice mode
                    $query->whereNotNull('student_masters.filiere');
                }
            })
            ->get();



        $nameFile = 'List-etudiant-Master-' . $filiere->nom_abrv . '.xlsx';

        return Excel::download(new StudentMasterExport($etablissement, $etudiants), $nameFile);

    }

    //Télécharger la liste de tous les étudiants de tout les filiéres de toute l'établissement
    public function downloadStudentsMasterMultiplechoix(Etablissement $etablissement){
        $multipleChoixFiliereMaster = auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_master == 1;

        $etudiants = DB::table('student_masters')
            ->select('student_masters.*',
                DB::raw($multipleChoixFiliereMaster ?
                    "filiere1.nom_complet AS filiere_choix_1_name,
                    filiere2.nom_complet AS filiere_choix_2_name,
                    filiere3.nom_complet AS filiere_choix_3_name"
                    :
                    "filiere.nom_complet AS filiere_name"
                )
            )
            ->leftJoin('filieres AS filiere1', 'student_masters.filiere_choix_1', '=', 'filiere1.id')
            ->leftJoin('filieres AS filiere2', 'student_masters.filiere_choix_2', '=', 'filiere2.id')
            ->leftJoin('filieres AS filiere3', 'student_masters.filiere_choix_3', '=', 'filiere3.id')
            ->leftJoin('filieres AS filiere', 'student_masters.filiere', '=', 'filiere.id')
            ->where(function ($query) use ($multipleChoixFiliereMaster) {
                if ($multipleChoixFiliereMaster) {
                    $query->whereNotNull('student_masters.filiere_choix_1')
                        ->orWhereNotNull('student_masters.filiere_choix_2')
                        ->orWhereNotNull('student_masters.filiere_choix_3');
                } else {
                    $query->whereNotNull('student_masters.filiere');
                }
            })
            ->get();


        $nameFile = 'List-etudiant-Master-' . $etablissement->nom_abrev . '.xlsx';

        return Excel::download(new StudentMasterExport($etablissement, $etudiants), $nameFile);
    }

    public function showDetailStudentMaster(Filiere $filiere,$etudiant){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $multipleChoixFiliereMaster = auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_master == 1;

        $etudiant = DB::table('student_masters')
        ->select('student_masters.*',
            // Separate columns for each filiere choice if multiple choices are allowed
            DB::raw($multipleChoixFiliereMaster ?
                "filiere1.nom_complet AS filiere_choix_1_name,
                filiere2.nom_complet AS filiere_choix_2_name,
                filiere3.nom_complet AS filiere_choix_3_name"
                :
                "filiere.nom_complet AS filiere_name" // Only one column for the single filiere
            )
        )
        ->leftJoin('filieres AS filiere1', 'student_masters.filiere_choix_1', '=', 'filiere1.id')
        ->leftJoin('filieres AS filiere2', 'student_masters.filiere_choix_2', '=', 'filiere2.id')
        ->leftJoin('filieres AS filiere3', 'student_masters.filiere_choix_3', '=', 'filiere3.id')
        ->leftJoin('filieres AS filiere', function ($join) {
            $join->on('student_masters.filiere', '=', 'filiere.id');
        })
        ->where(function ($query) use ($filiere, $multipleChoixFiliereMaster) {
            // Ensure we are filtering based on the provided filiere ID
            if ($multipleChoixFiliereMaster) {
                $query->where('filiere1.id', $filiere->id)
                    ->orWhere('filiere2.id', $filiere->id)
                    ->orWhere('filiere3.id', $filiere->id);
            } else {
                $query->where('student_masters.filiere', $filiere->id);
            }
        })
        ->where('student_masters.id', $etudiant)  // Filter by the student ID
        ->first(); // Use `first()` to get a single record

        // If the student exists, $etudiant will contain the data; otherwise, it will be null

        return view('admin-etab.etudiant.detailEtudiantMaster',compact('multipleChoixFiliereMaster','filiere','etudiant','etablissement'));
    }


    public function showStudentsLicenceExcellence(Filiere $filiere,Request $request){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        if ($request->ajax()) {

            if($filiere->etablissement->multiple_choix_filiere_passerelle){
                $query = StudentPasserelle::where('filiere_choix_1',$filiere->id)
                ->orWhere('filiere_choix_2',$filiere->id)
                ->orWhere('filiere_choix_3',$filiere->id);
            }else{
                $query = StudentPasserelle::where('filiere',$filiere->id);
            }

            // Apply search filters if any
            if ($request->filled('search.value')) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', "%$search%")
                    ->orWhere('prenom', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('CIN', 'like', "%$search%")
                    ->orWhere('dernier_diplome_obtenu', 'like', "%$search%")
                    ->orWhere('type_diplome_obtenu', 'like', "%$search%")
                    ->orWhere('specialitediplome', 'like', "%$search%")
                    ->orWhere('verif', 'like', "%$search%");
                });
            }

            $query->inRandomOrder();

            // Paginate the query based on the requested page
            $perPage = $request->input('length', 10); // Number of items per page
            $page = $request->input('start', 0) / $perPage + 1; // Current page number
            $data = $query->paginate($perPage, ['*'], 'page', $page);

            // Transform the data to include actions and related model attributes
            $transformedData = $data->map(function ($etudiant) use($filiere){
                // Determine the badge class based on 'verif' status
                $badgeClass = match ($etudiant->verif) {
                    'EN COURS'   => 'badge bg-warning text-white',
                    'REJETER'    => 'badge bg-danger text-white',
                    'VERIFIER'   => 'badge bg-success text-white',
                    default      => 'badge bg-secondary',
                };

                return [
                    'id'            => $etudiant->id,
                    'nom'           => $etudiant->nom,
                    'prenom'        => $etudiant->prenom,
                    'CIN'           => $etudiant->CIN,
                    'email'         => $etudiant->email,
                    'phone'         => $etudiant->phone,
                    'dernier_diplome_obtenu'   => $etudiant->dernier_diplome_obtenu,
                    'type_diplome_obtenu'   => $etudiant->type_diplome_obtenu,
                    'specialitediplome'   => $etudiant->specialitediplome,
                    'ville_etablissement_diplome'   => $etudiant->ville_etablissement_diplome,
                    'verif'         => '<span class="' . $badgeClass . '">' . $etudiant->verif . '</span>',
                    'actions' => '<a href="'.route('admin-etab.filiere.licenceExcellence.etudiants.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('admin-etab.etudiant.indexLicenceExcellenceStudents',compact('etablissement','filiere'));
    }

    public function showDetailStudentLicenceExcellence(Filiere $filiere,$etudiant){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $multipleChoixFiliereLicenceExcellence = auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_passerelle == 1;

        $etudiant = DB::table('student_passerelles')
        ->select('student_passerelles.*',
            // Separate columns for each filiere choice if multiple choices are allowed
            DB::raw($multipleChoixFiliereLicenceExcellence ?
                "filiere1.nom_complet AS filiere_choix_1_name,
                filiere2.nom_complet AS filiere_choix_2_name,
                filiere3.nom_complet AS filiere_choix_3_name"
                :
                "filiere.nom_complet AS filiere_name" // Only one column for the single filiere
            )
        )
        ->leftJoin('filieres AS filiere1', 'student_passerelles.filiere_choix_1', '=', 'filiere1.id')
        ->leftJoin('filieres AS filiere2', 'student_passerelles.filiere_choix_2', '=', 'filiere2.id')
        ->leftJoin('filieres AS filiere3', 'student_passerelles.filiere_choix_3', '=', 'filiere3.id')
        ->leftJoin('filieres AS filiere', function ($join) {
            $join->on('student_passerelles.filiere', '=', 'filiere.id');
        })
        ->where(function ($query) use ($filiere, $multipleChoixFiliereLicenceExcellence) {
            // Ensure we are filtering based on the provided filiere ID
            if ($multipleChoixFiliereLicenceExcellence) {
                $query->where('filiere1.id', $filiere->id)
                    ->orWhere('filiere2.id', $filiere->id)
                    ->orWhere('filiere3.id', $filiere->id);
            } else {
                $query->where('student_passerelles.filiere', $filiere->id);
            }
        })
        ->where('student_passerelles.id', $etudiant)  // Filter by the student ID
        ->first(); // Use `first()` to get a single record

        // If the student exists, $etudiant will contain the data; otherwise, it will be null

        return view('admin-etab.etudiant.detailEtudiantLicenceExcellence',compact('multipleChoixFiliereLicenceExcellence','filiere','etudiant','etablissement'));
    }


    public function downloadStudentsLicenceExcellence(Filiere $filiere){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $multiple_choix_filiere_passerelle = auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_passerelle == 1;

        $etudiants = DB::table('student_passerelles')
            ->select('student_passerelles.*',
                DB::raw($multiple_choix_filiere_passerelle ?
                    "filiere1.nom_complet AS filiere_choix_1_name,
                    filiere2.nom_complet AS filiere_choix_2_name,
                    filiere3.nom_complet AS filiere_choix_3_name"
                    :
                    "filiere.nom_complet AS filiere_name"
                )
            )
            ->leftJoin('filieres AS filiere1', 'student_passerelles.filiere_choix_1', '=', 'filiere1.id')
            ->leftJoin('filieres AS filiere2', 'student_passerelles.filiere_choix_2', '=', 'filiere2.id')
            ->leftJoin('filieres AS filiere3', 'student_passerelles.filiere_choix_3', '=', 'filiere3.id')
            ->leftJoin('filieres AS filiere', 'student_passerelles.filiere', '=', 'filiere.id')
            ->where(function ($query) use ($filiere, $multiple_choix_filiere_passerelle) {
                if ($multiple_choix_filiere_passerelle) {
                    $query->where('filiere1.id', $filiere->id)
                        ->orWhere('filiere2.id', $filiere->id)
                        ->orWhere('filiere3.id', $filiere->id);
                } else {
                    $query->where('student_passerelles.filiere', $filiere->id);
                }
            })
            ->where(function ($query) use ($multiple_choix_filiere_passerelle) {
                if ($multiple_choix_filiere_passerelle) {
                    // Exclude students where all filiere choices are NULL
                    $query->whereNotNull('student_passerelles.filiere_choix_1')
                        ->orWhereNotNull('student_passerelles.filiere_choix_2')
                        ->orWhereNotNull('student_passerelles.filiere_choix_3');
                } else {
                    // Exclude students with NULL filiere in single-choice mode
                    $query->whereNotNull('student_passerelles.filiere');
                }
            })
            ->get();



        $nameFile = 'List-etudiant-Passerelle-' . $filiere->nom_abrv . '.xlsx';

        return Excel::download(new StudentPasserelleExport($etablissement, $etudiants), $nameFile);
    }

    //Télécharger la liste de tous les étudiants de tout les filiéres de toute l'établissement
    public function downloadStudentsLicenceExcellenceMultiplechoix(Etablissement $etablissement){
        $multiple_choix_filiere_passerelle = auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_passerelle == 1;

        $etudiants = DB::table('student_passerelles')
            ->select('student_passerelles.*',
                DB::raw($multiple_choix_filiere_passerelle ?
                    "filiere1.nom_complet AS filiere_choix_1_name,
                    filiere2.nom_complet AS filiere_choix_2_name,
                    filiere3.nom_complet AS filiere_choix_3_name"
                    :
                    "filiere.nom_complet AS filiere_name"
                )
            )
            ->leftJoin('filieres AS filiere1', 'student_passerelles.filiere_choix_1', '=', 'filiere1.id')
            ->leftJoin('filieres AS filiere2', 'student_passerelles.filiere_choix_2', '=', 'filiere2.id')
            ->leftJoin('filieres AS filiere3', 'student_passerelles.filiere_choix_3', '=', 'filiere3.id')
            ->leftJoin('filieres AS filiere', 'student_passerelles.filiere', '=', 'filiere.id')
            ->where(function ($query) use ($multiple_choix_filiere_passerelle) {
                if ($multiple_choix_filiere_passerelle) {
                    $query->whereNotNull('student_passerelles.filiere_choix_1')
                        ->orWhereNotNull('student_passerelles.filiere_choix_2')
                        ->orWhereNotNull('student_passerelles.filiere_choix_3');
                } else {
                    $query->whereNotNull('student_passerelles.filiere');
                }
            })
            ->get();


        $nameFile = 'List-etudiant-Passerelle-' . $etablissement->nom_abrev . '.xlsx';

        return Excel::download(new StudentPasserelleExport($etablissement, $etudiants), $nameFile);
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

    public function activer(Filiere $filiere){
        $filiere->update([
            'active' => 1
        ]);
        $etablissement = Etablissement::where('responsable_id',Auth::id())->first();
        switch ($filiere->type) {
            case 1:
                $filieres = DB::table('filieres')
                ->select('filieres.*', 'users.name as responsable') // Get the name of the responsible person
                ->leftJoin('student_masters', function ($join) {
                    if (auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_master == 1) {
                        $join->on('student_masters.filiere_choix_1', '=', 'filieres.id')
                            ->orOn('student_masters.filiere_choix_2', '=', 'filieres.id')
                            ->orOn('student_masters.filiere_choix_3', '=', 'filieres.id');
                    } else {
                        $join->on('student_masters.filiere', '=', 'filieres.id');
                    }
                })
                ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id') // Join users table to get responsable name
                ->where('filieres.etablissement_id', $etablissement->id)
                ->where('filieres.type', 1)
                ->groupBy('filieres.id', 'users.name') // Add users.name to group by
                ->selectRaw('COUNT(student_masters.id) as students_count')
                ->get();
                break;
            case 2:
                $filieres = DB::table('filieres')
                ->select('filieres.*', 'users.name as responsable') // Get the name of the responsible person
                ->leftJoin('student_passerelles', function ($join) {
                    if (auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_passerelle == 1) {
                        $join->on('student_passerelles.filiere_choix_1', '=', 'filieres.id')
                            ->orOn('student_passerelles.filiere_choix_2', '=', 'filieres.id')
                            ->orOn('student_passerelles.filiere_choix_3', '=', 'filieres.id');
                    } else {
                        $join->on('student_passerelles.filiere', '=', 'filieres.id');
                    }
                })
                ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id') // Join users table to get responsable name
                ->where('filieres.etablissement_id', $etablissement->id)
                ->where('filieres.type', 2)
                ->groupBy('filieres.id', 'users.name') // Add users.name to group by
                ->selectRaw('COUNT(student_passerelles.id) as students_count')
                ->get();
                break;
            case 3:
                if($filiere->accee_ouvert == 1){
                    $filieres = Filiere::where('etablissement_id',$etablissement->id)
                        ->where('type',3)
                        ->where('accee_ouvert',1)
                        ->with('responsable')
                        ->withCount(['licenceAcceOuvertStudents'])
                        ->get();
                }else{
                    $filieres = Filiere::where('etablissement_id',$etablissement->id)
                        ->where('type',3)
                        ->where('accee_ouvert',0)
                        ->with('responsable')
                        ->withCount(['licenceAcceOuvertStudents'])
                        ->get();
                }
                break;
            default:
                $filieres = Filiere::where('etablissement_id',$etablissement->id)
                    ->where('type',1)
                    ->with('responsable')
                    ->withCount(['licenceStudents'])
                    ->get();
                break;
        }

        return response()->json(['status' => 1,'message' => 'Cette filiere est activé maintenant','filieres' => $filieres]);
    }

    public function desactiver(Filiere $filiere){
        $filiere->update([
            'active' => 0
        ]);

        $etablissement = Etablissement::where('responsable_id',Auth::id())->first();

        switch ($filiere->type) {
            case 1:
                $filieres = DB::table('filieres')
                ->select('filieres.*', 'users.name as responsable') // Get the name of the responsible person
                ->leftJoin('student_masters', function ($join) {
                    if (auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_master == 1) {
                        $join->on('student_masters.filiere_choix_1', '=', 'filieres.id')
                            ->orOn('student_masters.filiere_choix_2', '=', 'filieres.id')
                            ->orOn('student_masters.filiere_choix_3', '=', 'filieres.id');
                    } else {
                        $join->on('student_masters.filiere', '=', 'filieres.id');
                    }
                })
                ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id') // Join users table to get responsable name
                ->where('filieres.etablissement_id', $etablissement->id)
                ->where('filieres.type', 1)
                ->groupBy('filieres.id', 'users.name') // Add users.name to group by
                ->selectRaw('COUNT(student_masters.id) as students_count')
                ->get();
                break;
            case 2:
                $filieres = DB::table('filieres')
                ->select('filieres.*', 'users.name as responsable') // Get the name of the responsible person
                ->leftJoin('student_passerelles', function ($join) {
                    if (auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_passerelle == 1) {
                        $join->on('student_passerelles.filiere_choix_1', '=', 'filieres.id')
                            ->orOn('student_passerelles.filiere_choix_2', '=', 'filieres.id')
                            ->orOn('student_passerelles.filiere_choix_3', '=', 'filieres.id');
                    } else {
                        $join->on('student_passerelles.filiere', '=', 'filieres.id');
                    }
                })
                ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id') // Join users table to get responsable name
                ->where('filieres.etablissement_id', $etablissement->id)
                ->where('filieres.type', 2)
                ->groupBy('filieres.id', 'users.name') // Add users.name to group by
                ->selectRaw('COUNT(student_passerelles.id) as students_count')
                ->get();
                break;
            case 3:
                if($filiere->accee_ouvert == 1){
                    $filieres = Filiere::where('etablissement_id',$etablissement->id)
                        ->where('type',3)
                        ->where('accee_ouvert',1)
                        ->with('responsable')
                        ->withCount(['licenceAcceOuvertStudents'])
                        ->get();
                }else{
                    $filieres = Filiere::where('etablissement_id',$etablissement->id)
                        ->where('type',3)
                        ->where('accee_ouvert',0)
                        ->with('responsable')
                        ->withCount(['licenceAcceOuvertStudents'])
                        ->get();
                }
                break;
            default:
                $filieres = Filiere::where('etablissement_id',$etablissement->id)
                    ->where('type',1)
                    ->with('responsable')
                    ->withCount(['licenceStudents'])
                    ->get();
                break;
        }

        return response()->json(['status' => 1,'message' => 'Cette filiere est activé maintenant','filieres' => $filieres]);
    }

    public function updateProvinceFiliere(Filiere $filiere,Request $request){

    }
}
