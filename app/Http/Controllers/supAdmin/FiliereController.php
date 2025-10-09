<?php

namespace App\Http\Controllers\supAdmin;

use App\Models\User;
use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class FiliereController extends Controller
{

    public function categorie(Etablissement $etablissement){
      $filieresMaster = DB::table('filieres')
        ->select('filieres.*', 'users.name as responsable', DB::raw('COUNT(student_masters.id) as students_count'))
        ->leftJoin('student_masters', function ($join) use ($etablissement) {
            if ($etablissement->multiple_choix_filiere_master == 1) {
                $join->on(function ($q) {
                    $q->on('student_masters.filiere_choix_1', '=', 'filieres.id')
                    ->orOn('student_masters.filiere_choix_2', '=', 'filieres.id')
                    ->orOn('student_masters.filiere_choix_3', '=', 'filieres.id');
                });
            } else {
                $join->on('student_masters.filiere', '=', 'filieres.id');
            }
        })
        ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id')
        ->where('filieres.type', 1)
        ->where('filieres.etablissement_id', $etablissement->id)
        ->groupBy('filieres.id', 'users.name')
        ->get();
        $filieresPasserelle = DB::table('filieres')
        ->select('filieres.*', 'users.name as responsable', DB::raw('COUNT(student_passerelles.id) as students_count'))
        ->leftJoin('student_passerelles', function ($join) use ($etablissement) {
            if ($etablissement->multiple_choix_filiere_passerelle == 1) {
                $join->on(function ($q) {
                    $q->on('student_passerelles.filiere_choix_1', '=', 'filieres.id')
                    ->orOn('student_passerelles.filiere_choix_2', '=', 'filieres.id')
                    ->orOn('student_passerelles.filiere_choix_3', '=', 'filieres.id');
                });
            } else {
                $join->on('student_passerelles.filiere', '=', 'filieres.id');
            }
        })
        ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id')
        ->where('filieres.type', 2)
        ->where('filieres.etablissement_id', $etablissement->id)
        ->groupBy('filieres.id', 'users.name')
        ->get();
        return view('sup-admin.filiere.categorie',compact('filieresMaster','filieresPasserelle'));
    }

    public function showEtudiantsMaster(Filiere $filiere,Request $request){
        $filiere->load('etablissement','responsable');
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
    
            $transformedData = $data->map(function ($etudiant) use($filiere) {
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
                    'actions'       => '<a href="' . route('sup-admin.filiere.master.etudiants.show', ['filiere' => $filiere->id, 'etudiant' => $etudiant->id]) . '" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });
    
            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }
    
        return view('sup-admin.filiere.indexMasterStudents',compact('etablissement','filiere'));
    }

    public function showDetailStudentMaster(Filiere $filiere,$etudiant){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;
        $responsable = $filiere->responsable;


        $multipleChoixFiliereMaster = $etablissement->multiple_choix_filiere_master == 1;

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

        return view('sup-admin.filiere.detailEtudiantMaster',compact('multipleChoixFiliereMaster','filiere','etudiant','etablissement'));
    }

    public function editMasterCandidat($candidat)
    {
        $studentMaster =  StudentMaster::whereId($candidat)->first();

        $user = User::whereId($studentMaster->user_id)->first();

        return view('sup-admin.filiere.editMasterCandidat',compact('user'));
    }

    public function updateMasterCandidat(Request $request,$candidat){
        $request->validate([
            'password' => 'required'
        ]);
        $user = User::whereId($candidat)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return back()->with('message','Mot de passe et modifié avec succées');
    }


    public function showEtudiantsPasserelle(Filiere $filiere,Request $request){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;
        $responsable = $filiere->responsable;

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
                    'actions' => '<a href="'.route('sup-admin.filiere.licenceExcellence.etudiants.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });
    
            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }
    
        return view('sup-admin.filiere.indexLicenceExcellenceStudents',compact('etablissement','filiere'));
    }


    public function showDetailStudentLicenceExcellence(Filiere $filiere,$etudiant){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $responsable = $filiere->responsable;


        $multipleChoixFiliereLicenceExcellence = $etablissement->multiple_choix_filiere_passerelle == 1;

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

        return view('sup-admin.filiere.detailEtudiantLicenceExcellence',compact('multipleChoixFiliereLicenceExcellence','filiere','etudiant','etablissement'));
    }

    public function editPasserelleCandidat($candidat)
    {
        $studentPasserelle =  StudentPasserelle::whereId($candidat)->first();
        
        $user = User::whereId($studentPasserelle->user_id)->first();

        return view('sup-admin.filiere.editPasserelleCandidat',compact('user'));
    }

    public function updatePasserelleCandidat(Request $request,$candidat){
        $request->validate([
            'password' => 'required'
        ]);
        $user = User::whereId($candidat)->first();

        $user->update([
            'password' => Hash::make($request->password)
        ]);
        return back()->with('message','Mot de passe et modifié avec succées');
    }
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
