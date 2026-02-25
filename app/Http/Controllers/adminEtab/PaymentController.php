<?php

namespace App\Http\Controllers\adminEtab;

use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\PaymentMaster;
use App\Models\StudentMaster;
use App\Models\PaymentBacheliers;
use App\Models\PaymentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function paymentFiliereMaster()
    {
        $etablissement = Etablissement::where('responsable_id', Auth::id())->first();

        // Retrieve filieres with responsible relation
        $filieres = DB::table('filieres')
        ->select('filieres.*', 'users.name as responsable') // Get the name of the responsible person
        ->leftJoin('payment_masters', function ($join) {
            $join->on('payment_masters.filiere', '=', 'filieres.id');
        })
        ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id') // Join users table to get responsable name
        ->where('filieres.etablissement_id', $etablissement->id)
        ->where('filieres.type', 1)
        ->groupBy('filieres.id', 'users.name') // Add users.name to group by
        ->selectRaw('COUNT(payment_masters.id) as students_count')
        ->get();


        return view('admin-etab.payment.indexMaster', compact('etablissement','filieres'));
    }

    public function paymentFiliereMasterStudents(Filiere $filiere, Request $request){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        if ($request->ajax()) {

            $query = PaymentMaster::where('filiere',$filiere->id);
            

            // Apply search filters if any
            if ($request->filled('search.value')) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', "%$search%")
                    ->orWhere('prenom', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('CIN', 'like', "%$search%");
                });
            }
            
            $query->orderBy('id', 'desc');

            // Paginate the query based on the requested page
            $perPage = $request->input('length', 10); // Number of items per page
            $page = $request->input('start', 0) / $perPage + 1; // Current page number
            $data = $query->paginate($perPage, ['*'], 'page', $page);

            // Transform the data to include actions and related model attributes
            $transformedData = $data->map(function ($etudiant) use($filiere){
                // Determine the badge class based on 'verif' status
                $badgeClass = match ($etudiant->etat_payment) {
                    'En attente'   => 'badge bg-warning text-white',
                    'Partielle'    => 'badge bg-secondary text-white',
                    'Complete'   => 'badge bg-success text-white',
                    default      => 'badge bg-secondary',
                };

                return [
                    'id'            => $etudiant->id,
                    'nom'           => $etudiant->nom,
                    'prenom'        => $etudiant->prenom,
                    'CIN'           => $etudiant->CIN,
                    'email'         => $etudiant->email,
                    'phone'         => $etudiant->phone,
                    'type_master'   => $etudiant->type_master,
                    'montant'       => $etudiant->montant_paye,
                    'date_inscription' => $etudiant->date_inscription,
                    'student_id'    => $etudiant->student_id,
                    'etat_payment'  => '<span class="' . $badgeClass . '">' . $etudiant->etat_payment . '</span>',
                    'actions' => '<a href="'.route('admin-etab.payment.master.filiere.student.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('admin-etab.payment.indexMasterStudents',compact('etablissement','filiere'));
    }

    public function paymentFiliereMasterShowStudent(Filiere $filiere,$etudiant){
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
                "filiere.nom_complet AS filiere_name", // Only one column for the single filiere
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

        $payments = PaymentMaster::where('student_id',$etudiant->id)->get();

        // If the student exists, $etudiant will contain the data; otherwise, it will be null

        return view('admin-etab.payment.showStudentPaymentMaster',compact('multipleChoixFiliereMaster','filiere','etudiant','etablissement','payments'));
    }

    public function paymentFiliereMasterStore(Filiere $filiere,StudentMaster $etudiant,Request $request){
        $request->validate([
            'student_id'        => 'required',
            'CNE'               => 'required',
            'CIN'               => 'required',
            'nom'               => 'required',
            'prenom'            => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'filiere'           => 'required',
            'date_inscription'  => 'required',
            'type_master'       => 'required',
            'etat_payment'      => 'required',
            'montant_paye'      => 'required',
        ]);
        if($request->etat_payment != "Complete(Fonctionnaire à l'UH1)"){
            $request->validate([
                'file'          => 'required'
            ]);
        }
        
        if ($request->file) {
            $fileName = $request->file;
            $filePath = storage_path('tmp/uploads/') . $fileName;

            $fileExists = File::exists($filePath);

            if ($fileExists) {
                File::move(storage_path('tmp/uploads/'. basename($request->file)),public_path('uploads/paiement/'. basename($request->file)));
                $request['document'] = 'uploads/paiement/'. basename($request->file);
            } else {
                $request['document'] = null;
            }
        }else{
            $request['document'] = null;
        }

        PaymentMaster::updateOrCreate(
            [
                'CNE' => $request->CNE,
                'CIN' => $request->CIN,
                'type_master' => $request->type_master
            ],
            $request->all()
        );
        return redirect()->route('admin-etab.payment.master.filiere.students',$request->filiere)->with('message','Le paiement a été enregistré avec succès');
    }


    public function paymentFiliereLicence(){
        $etablissement = Etablissement::where('responsable_id', Auth::id())->first();

        // Retrieve filieres with responsible relation
        $filieres = DB::table('filieres')
        ->select('filieres.*', 'users.name as responsable') // Get the name of the responsible person
        ->leftJoin('payment_passerelles', function ($join) {
            $join->on('payment_passerelles.filiere', '=', 'filieres.id');
        })
        ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id') // Join users table to get responsable name
        ->where('filieres.etablissement_id', $etablissement->id)
        ->where('filieres.type', 2)
        ->groupBy('filieres.id', 'users.name') // Add users.name to group by
        ->selectRaw('COUNT(payment_passerelles.id) as students_count')
        ->get();


        return view('admin-etab.payment.indexPasserelle', compact('etablissement','filieres'));
    }

    public function paymentFiliereLicenceStudents(Filiere $filiere, Request $request){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        if ($request->ajax()) {

            $query = PaymentPasserelle::where('filiere',$filiere->id);
            

            // Apply search filters if any
            if ($request->filled('search.value')) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', "%$search%")
                    ->orWhere('prenom', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('CIN', 'like', "%$search%");
                });
            }
            
            $query->orderBy('id', 'desc');

            // Paginate the query based on the requested page
            $perPage = $request->input('length', 10); // Number of items per page
            $page = $request->input('start', 0) / $perPage + 1; // Current page number
            $data = $query->paginate($perPage, ['*'], 'page', $page);

            // Transform the data to include actions and related model attributes
            $transformedData = $data->map(function ($etudiant) use($filiere){
                // Determine the badge class based on 'verif' status
                $badgeClass = match ($etudiant->etat_payment) {
                    'En attente'   => 'badge bg-warning text-white',
                    'Partielle'    => 'badge bg-secondary text-white',
                    'Complete'   => 'badge bg-success text-white',
                    default      => 'badge bg-secondary',
                };

                return [
                    'id'            => $etudiant->id,
                    'nom'           => $etudiant->nom,
                    'prenom'        => $etudiant->prenom,
                    'CIN'           => $etudiant->CIN,
                    'email'         => $etudiant->email,
                    'phone'         => $etudiant->phone,
                    'montant'       => $etudiant->montant_paye,
                    'date_inscription' => $etudiant->date_inscription,
                    'student_id'    => $etudiant->student_id,
                    'etat_payment'  => '<span class="' . $badgeClass . '">' . $etudiant->etat_payment . '</span>',
                    'actions' => '<a href="'.route('admin-etab.payment.licence.filiere.student.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('admin-etab.payment.indexLicenceStudents',compact('etablissement','filiere'));
    }


    public function paymentFiliereLicenceStore(Filiere $filiere,StudentMaster $etudiant,Request $request){
        $request->validate([
            'student_id'        => 'required',
            'CNE'               => 'required',
            'CIN'               => 'required',
            'nom'               => 'required',
            'prenom'            => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'filiere'           => 'required',
            'date_inscription'  => 'required',
            'etat_payment'      => 'required',
            'montant_paye'      => 'required',
        ]);
        if($request->etat_payment != "Complete(Fonctionnaire à l'UH1)"){
            $request->validate([
                'file'          => 'required'
            ]);
        }
        
        if ($request->file) {
            $fileName = $request->file;
            $filePath = storage_path('tmp/uploads/') . $fileName;

            $fileExists = File::exists($filePath);

            if ($fileExists) {
                File::move(storage_path('tmp/uploads/'. basename($request->file)),public_path('uploads/paiement/'. basename($request->file)));
                $request['document'] = 'uploads/paiement/'. basename($request->file);
            } else {
                $request['document'] = null;
            }
        }else{
            $request['document'] = null;
        }

        PaymentPasserelle::updateOrCreate(
            [
                'CNE' => $request->CNE,
                'CIN' => $request->CIN
            ],
            $request->all()
        );
        return redirect()->route('admin-etab.payment.licence.filiere.students',$request->filiere)->with('message','Le paiement a été enregistré avec succès');
    }

    public function paymentFiliereLicenceShowStudent(Filiere $filiere,$etudiant){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $multipleChoixFilierePasserelles = auth()->user() && auth()->user()->etablissement->multiple_choix_filiere_passerelle == 1;

        $etudiant = DB::table('student_passerelles')
        ->select('student_passerelles.*',
            // Separate columns for each filiere choice if multiple choices are allowed
            DB::raw($multipleChoixFilierePasserelles ?
                "filiere1.nom_complet AS filiere_choix_1_name,
                filiere2.nom_complet AS filiere_choix_2_name,
                filiere3.nom_complet AS filiere_choix_3_name"
                :
                "filiere.nom_complet AS filiere_name", // Only one column for the single filiere
            )
        )
        ->leftJoin('filieres AS filiere1', 'student_passerelles.filiere_choix_1', '=', 'filiere1.id')
        ->leftJoin('filieres AS filiere2', 'student_passerelles.filiere_choix_2', '=', 'filiere2.id')
        ->leftJoin('filieres AS filiere3', 'student_passerelles.filiere_choix_3', '=', 'filiere3.id')
        ->leftJoin('filieres AS filiere', function ($join) {
            $join->on('student_passerelles.filiere', '=', 'filiere.id');
        })
        ->where(function ($query) use ($filiere, $multipleChoixFilierePasserelles) {
            // Ensure we are filtering based on the provided filiere ID
            if ($multipleChoixFilierePasserelles) {
                $query->where('filiere1.id', $filiere->id)
                    ->orWhere('filiere2.id', $filiere->id)
                    ->orWhere('filiere3.id', $filiere->id);
            } else {
                $query->where('student_passerelles.filiere', $filiere->id);
            }
        })
        ->where('student_passerelles.id', $etudiant)  // Filter by the student ID
        ->first(); // Use `first()` to get a single record

        $payments = PaymentPasserelle::where('student_id',$etudiant->id)->get();

        // If the student exists, $etudiant will contain the data; otherwise, it will be null

        return view('admin-etab.payment.showStudentPaymentPasserelles',compact('multipleChoixFilierePasserelles','filiere','etudiant','etablissement','payments'));
    }

    public function paymentFiliereBachelier(){
        $etablissement = Etablissement::where('responsable_id', Auth::id())->first();

        // Retrieve filieres with responsible relation
        $filieres = DB::table('filieres')
        ->select('filieres.*', 'users.name as responsable') // Get the name of the responsible person
        ->leftJoin('payment_bacheliers', function ($join) {
            $join->on('payment_bacheliers.filiere', '=', 'filieres.id');
        })
        ->leftJoin('users', 'users.id', '=', 'filieres.responsable_id') // Join users table to get responsable name
        ->where('filieres.etablissement_id', $etablissement->id)
        ->where('filieres.type', 3)
        ->groupBy('filieres.id', 'users.name') // Add users.name to group by
        ->selectRaw('COUNT(payment_bacheliers.id) as students_count')
        ->get();


        return view('admin-etab.payment.indexBachelier', compact('etablissement','filieres'));
    }

    public function paymentFiliereBachelierStudents(Filiere $filiere, Request $request){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        if ($request->ajax()) {

            $query = PaymentBacheliers::where('filiere',$filiere->id);
            

            // Apply search filters if any
            if ($request->filled('search.value')) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('nom', 'like', "%$search%")
                    ->orWhere('prenom', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%")
                    ->orWhere('phone', 'like', "%$search%")
                    ->orWhere('CIN', 'like', "%$search%");
                });
            }
            
            $query->orderBy('id', 'desc');

            // Paginate the query based on the requested page
            $perPage = $request->input('length', 10); // Number of items per page
            $page = $request->input('start', 0) / $perPage + 1; // Current page number
            $data = $query->paginate($perPage, ['*'], 'page', $page);

            // Transform the data to include actions and related model attributes
            $transformedData = $data->map(function ($etudiant) use($filiere){
                // Determine the badge class based on 'verif' status
                $badgeClass = match ($etudiant->etat_payment) {
                    'En attente'   => 'badge bg-warning text-white',
                    'Partielle'    => 'badge bg-secondary text-white',
                    'Complete'   => 'badge bg-success text-white',
                    default      => 'badge bg-secondary',
                };

                return [
                    'id'            => $etudiant->id,
                    'nom'           => $etudiant->nom,
                    'prenom'        => $etudiant->prenom,
                    'CIN'           => $etudiant->CIN,
                    'email'         => $etudiant->email,
                    'phone'         => $etudiant->phone,
                    'semestre'      => $etudiant->semestre,
                    'montant'       => $etudiant->montant_paye,
                    'date_inscription' => $etudiant->date_inscription,
                    'student_id'    => $etudiant->student_id,
                    'etat_payment'  => '<span class="' . $badgeClass . '">' . $etudiant->etat_payment . '</span>',
                    'actions' => '<a href="'.route('admin-etab.payment.licence.filiere.student.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('admin-etab.payment.indexBachelierStudents',compact('etablissement','filiere'));
    }

    public function paymentFiliereBachelierStore(Filiere $filiere,StudentMaster $etudiant,Request $request){
        $request->validate([
            'student_id'        => 'required',
            'CNE'               => 'required',
            'CIN'               => 'required',
            'nom'               => 'required',
            'prenom'            => 'required',
            'email'             => 'required',
            'phone'             => 'required',
            'filiere'           => 'required',
            'date_inscription'  => 'required',
            'semestre'          => 'required',
            'etat_payment'      => 'required',
            'montant_paye'      => 'required',
        ]);

        if($request->etat_payment != "Complete(Fonctionnaire à l'UH1)"){
            $request->validate([
                'file'          => 'required'
            ]);
        }
        
        if ($request->file) {
            $fileName = $request->file;
            $filePath = storage_path('tmp/uploads/') . $fileName;

            $fileExists = File::exists($filePath);

            if ($fileExists) {
                File::move(storage_path('tmp/uploads/'. basename($request->file)),public_path('uploads/paiement/'. basename($request->file)));
                $request['document'] = 'uploads/paiement/'. basename($request->file);
            } else {
                $request['document'] = null;
            }
        }else{
            $request['document'] = null;
        }

        PaymentBacheliers::updateOrCreate(
            [
                'CNE' => $request->CNE,
                'CIN' => $request->CIN
            ],
            $request->all()
        );
        return redirect()->route('admin-etab.payment.bachelier.filiere.students',$request->filiere)->with('message','Le paiement a été enregistré avec succès');
    }

    public function paymentFiliereBachelierShowStudent(Filiere $filiere,$etudiant){
        if ($filiere->etablissement_id != auth()->user()->etablissement->id) {
            abort(403);
        }
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $multipleChoixFiliereBacheliers = auth()->user() && auth()->user()->etablissement->multiple_choix_filiere == 1;

        $etudiant = DB::table('bacheliers')
        ->select('bacheliers.*',
            // Separate columns for each filiere choice if multiple choices are allowed
            DB::raw($multipleChoixFiliereBacheliers ?
                "filiere1.nom_complet AS filiere_choix_1_name,
                filiere2.nom_complet AS filiere_choix_2_name,
                filiere3.nom_complet AS filiere_choix_3_name"
                :
                "filiere.nom_complet AS filiere_name", // Only one column for the single filiere
            )
        )
        ->leftJoin('filieres AS filiere1', 'bacheliers.filiere_choix_1', '=', 'filiere1.id')
        ->leftJoin('filieres AS filiere2', 'bacheliers.filiere_choix_2', '=', 'filiere2.id')
        ->leftJoin('filieres AS filiere3', 'bacheliers.filiere_choix_3', '=', 'filiere3.id')
        ->leftJoin('filieres AS filiere', function ($join) {
            $join->on('bacheliers.filiere', '=', 'filiere.id');
        })
        ->where(function ($query) use ($filiere, $multipleChoixFiliereBacheliers) {
            // Ensure we are filtering based on the provided filiere ID
            if ($multipleChoixFiliereBacheliers) {
                $query->where('filiere1.id', $filiere->id)
                    ->orWhere('filiere2.id', $filiere->id)
                    ->orWhere('filiere3.id', $filiere->id);
            } else {
                $query->where('bacheliers.filiere', $filiere->id);
            }
        })
        ->where('bacheliers.id', $etudiant)  // Filter by the student ID
        ->first(); // Use `first()` to get a single record

        $payments = PaymentBacheliers::where('student_id',$etudiant->id)->get();

        // If the student exists, $etudiant will contain the data; otherwise, it will be null

        return view('admin-etab.payment.showStudentPaymentBacheliers',compact('multipleChoixFiliereBacheliers','filiere','etudiant','etablissement','payments'));
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
