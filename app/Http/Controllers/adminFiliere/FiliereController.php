<?php

namespace App\Http\Controllers\adminFiliere;

use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use App\Models\StudentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Exports\StudentMasterExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StudentPasserelleExport;

class FiliereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function indexMaster(){
        $etab = Auth::user()->filiere->etablissement;

        // $filieresMasterCount = Filiere::where('responsable_id',Auth::id())->where('type',1)->count();
        // $filieresPasserelleCount = Filiere::where('responsable_id',Auth::id())->where('type',2)->count();

       $filieres = DB::table('filieres')
       ->select('filieres.*', 'users.name as responsable')
       ->leftJoin('student_masters', function ($join) {
           if (auth()->user() && auth()->user()->filiere && auth()->user()->filiere->etablissement->multiple_choix_filiere_master == 1) {
               $join->on('student_masters.filiere_choix_1', '=', 'filieres.id')
                    ->orOn('student_masters.filiere_choix_2', '=', 'filieres.id')
                    ->orOn('student_masters.filiere_choix_3', '=', 'filieres.id');
           } else {
               $join->on('student_masters.filiere', '=', 'filieres.id');
           }
       })
       ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id')
       ->where('filieres.responsable_id', Auth::id()) // ✅ Only filières of this responsable
       ->where('filieres.type', 1)
       ->groupBy('filieres.id', 'users.name')
       ->selectRaw('COUNT(student_masters.id) as students_count')
       ->get();


        return view('admin-filiere.filiere.indexMaster',compact('filieres'));
    }

    public function indexLicenceExcellence()
    {
        $etab = Auth::user()->filiere->etablissement;

        $filieres = DB::table('filieres')
            ->select('filieres.*', 'users.name as responsable')
            ->leftJoin('student_passerelles', function ($join) {
                if (
                    auth()->user() &&
                    auth()->user()->filiere &&
                    auth()->user()->filiere->etablissement->multiple_choix_filiere_passerelle == 1
                ) {
                    $join->on('student_passerelles.filiere_choix_1', '=', 'filieres.id')
                        ->orOn('student_passerelles.filiere_choix_2', '=', 'filieres.id')
                        ->orOn('student_passerelles.filiere_choix_3', '=', 'filieres.id');
                } else {
                    $join->on('student_passerelles.filiere', '=', 'filieres.id');
                }
            })
            ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id')
            ->where('filieres.responsable_id', Auth::id()) // 👈 Filter by responsable
            ->where('filieres.type', 2) // Type 2 = Licence Excellence / Passerelle
            ->groupBy('filieres.id', 'users.name')
            ->selectRaw('COUNT(student_passerelles.id) as students_count')
            ->get();

        return view('admin-filiere.filiere.indexLicencExcellence', compact('etab', 'filieres'));
    }


    public function showStudentsMaster (Filiere $filiere,Request $request){
        // return $filiere->load('masterStudents');
        // return $query = StudentMaster::where('filiere',$filiere->id)->with(['filiereMaster'])->get();
        $filiere->load('etablissement','responsable');
        $etablissement = $filiere->etablissement;
        $responsable = $filiere->responsable;

        if(Auth::id() != $responsable->id){
            abort(403);
        }

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
                    ->orWhere('ville_etablissement_diplome', 'like', "%$search%")
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
                    'actions'       => '<a href="' . route('admin-filiere.filiere.master.etudiants.show', ['filiere' => $filiere->id, 'etudiant' => $etudiant->id]) . '" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('admin-filiere.etudiant.indexMasterStudents',compact('etablissement','filiere'));
    }


    public function DonwloadStudentsMasterToSelect(Filiere $filiere)
    {
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $responsable = $filiere->responsable;

        if(Auth::id() != $responsable->id){
            abort(403);
        }

        $multipleChoixFiliereMaster = auth()->user() && auth()->user()->filiere->etablissement->multiple_choix_filiere_master == 1;

        $etudiants = DB::table('student_masters')
            ->select(
                'student_masters.*',
                DB::raw($multipleChoixFiliereMaster ?
                    "filiere1.nom_complet AS filiere_choix_1_name,
                    filiere2.nom_complet AS filiere_choix_2_name,
                    filiere3.nom_complet AS filiere_choix_3_name"
                    :
                    "filiere.nom_complet AS filiere_name"
                ),
                DB::raw('
                    (COALESCE(notes1, 0) +
                    COALESCE(notes2, 0) +
                    COALESCE(notes3, 0) +
                    COALESCE(notes4, 0) +
                    COALESCE(notes5, 0) +
                    COALESCE(notes6, 0)) / 6 as moyenne
                ')
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
                    $query->whereNotNull('student_masters.filiere_choix_1')
                        ->orWhereNotNull('student_masters.filiere_choix_2')
                        ->orWhereNotNull('student_masters.filiere_choix_3');
                } else {
                    $query->whereNotNull('student_masters.filiere');
                }
            })
            ->whereIn('verif', ['EN COURS', 'VERIFIER'])
            ->orderByDesc('moyenne')
            ->limit(300)
            ->get();

        $nameFile = 'Top-300-Etudiants-Master-' . $filiere->nom_abrv . '.xlsx';

        return Excel::download(new StudentMasterExport($etablissement, $etudiants), $nameFile);
    }


    public function downloadStudentsMaster(Filiere $filiere){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $responsable = $filiere->responsable;

        if(Auth::id() != $responsable->id){
            abort(403);
        }

        $multipleChoixFiliereMaster = auth()->user() && auth()->user()->filiere->etablissement->multiple_choix_filiere_master == 1;

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


    public function showDetailStudentMaster(Filiere $filiere,$etudiant){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;
        $responsable = $filiere->responsable;

        if(Auth::id() != $responsable->id){
            abort(403);
        }

        $multipleChoixFiliereMaster = auth()->user() && auth()->user()->filiere->etablissement->multiple_choix_filiere_master == 1;

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

        return view('admin-filiere.etudiant.detailEtudiantMaster',compact('multipleChoixFiliereMaster','filiere','etudiant','etablissement'));
    }

    public function showDetailStudentMasterToSelect(Filiere $filiere,$etudiant){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;
        $responsable = $filiere->responsable;

        if(Auth::id() != $responsable->id){
            abort(403);
        }

        $multipleChoixFiliereMaster = auth()->user() && auth()->user()->filiere->etablissement->multiple_choix_filiere_master == 1;

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

        return view('admin-filiere.etudiant.detailEtudiantMasterToSelect',compact('multipleChoixFiliereMaster','filiere','etudiant','etablissement'));
    }


    public function showStudentsLicenceExcellence(Filiere $filiere,Request $request){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;
        $responsable = $filiere->responsable;

        if(Auth::id() != $responsable->id){
            abort(403);
        }

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
                    ->orWhere('ville_etablissement_diplome', 'like', "%$search%")
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
                    'actions' => '<a href="'.route('admin-filiere.filiere.licenceExcellence.etudiants.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('admin-filiere.etudiant.indexLicenceExcellenceStudents',compact('etablissement','filiere'));
    }

    public function DonwloadStudentsLicenceExcellenceToSelect(Filiere $filiere){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $responsable = $filiere->responsable;

        if (Auth::id() != $responsable->id) {
            abort(403);
        }

        $multiple_choix_filiere_passerelle = auth()->user() && auth()->user()->filiere->etablissement->multiple_choix_filiere_passerelle == 1;

        $etudiants = DB::table('student_passerelles')
            ->select(
                'student_passerelles.*',
                DB::raw($multiple_choix_filiere_passerelle ?
                    "filiere1.nom_complet AS filiere_choix_1_name,
                    filiere2.nom_complet AS filiere_choix_2_name,
                    filiere3.nom_complet AS filiere_choix_3_name"
                    :
                    "filiere.nom_complet AS filiere_name"
                ),
                DB::raw('
                    (COALESCE(notes1, 0) +
                    COALESCE(notes2, 0) +
                    COALESCE(notes3, 0) +
                    COALESCE(notes4, 0)) / 4 AS moyenne
                ')
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
                    $query->whereNotNull('student_passerelles.filiere_choix_1')
                        ->orWhereNotNull('student_passerelles.filiere_choix_2')
                        ->orWhereNotNull('student_passerelles.filiere_choix_3');
                } else {
                    $query->whereNotNull('student_passerelles.filiere');
                }
            })
            ->whereIn('verif', ['EN COURS', 'VERIFIER'])
            ->orderByDesc('moyenne')
            ->limit(300)
            ->get();

        $nameFile = 'Top-300-Etudiants-Passerelle-' . $filiere->nom_abrv . '.xlsx';

        return Excel::download(new StudentPasserelleExport($etablissement, $etudiants), $nameFile);
    }

    public function showDetailStudentLicenceExcellence(Filiere $filiere,$etudiant){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $responsable = $filiere->responsable;

        if(Auth::id() != $responsable->id){
            abort(403);
        }

        $multipleChoixFiliereLicenceExcellence = auth()->user() && auth()->user()->filiere->etablissement->multiple_choix_filiere_passerelle == 1;

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

        return view('admin-filiere.etudiant.detailEtudiantLicenceExcellence',compact('multipleChoixFiliereLicenceExcellence','filiere','etudiant','etablissement'));
    }

    public function showDetailStudentLicenceExcellenceToSelect(Filiere $filiere,$etudiant){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $responsable = $filiere->responsable;

        if(Auth::id() != $responsable->id){
            abort(403);
        }

        $multipleChoixFiliereLicenceExcellence = auth()->user() && auth()->user()->filiere->etablissement->multiple_choix_filiere_passerelle == 1;

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

        return view('admin-filiere.etudiant.detailEtudiantLicenceExcellenceToSelect',compact('multipleChoixFiliereLicenceExcellence','filiere','etudiant','etablissement'));
    }

    public function downloadStudentsLicenceExcellence(Filiere $filiere){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $responsable = $filiere->responsable;

        if(Auth::id() != $responsable->id){
            abort(403);
        }

        $multiple_choix_filiere_passerelle = auth()->user() && auth()->user()->filiere->etablissement->multiple_choix_filiere_passerelle == 1;

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


    public function validerOuRejeterEtudiant(Request $request,Filiere $filiere,StudentMaster $etudiant){
        if ($request->action === 'valider') {
            $etudiant->verif = 'VERIFIER';
            $etudiant->motif = null;
        } elseif ($request->action === 'rejeter') {
            $etudiant->verif = 'REJETER';
            $etudiant->motif = $request->motif;
        }

        $etudiant->save();

        return redirect()->back()->with('message', 'Action enregistrée avec succès.');
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
