<?php

namespace App\Http\Controllers\supAdmin;

use OpenAI;
use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\PaymentMaster;
use App\Models\PaymentBacheliers;
use App\Models\PaymentPasserelle;
use Illuminate\Support\Facades\DB;
use App\Jobs\CheckMasterReceiptJob;


use App\Http\Controllers\Controller;
use App\Jobs\CheckLicenceReceiptJob;
use Illuminate\Support\Facades\Http;
use App\Jobs\CheckBachelierReceiptJob;



class PaiementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $etablissements = DB::table('etablissements as e')
        ->select(

            'e.*',

            /* ================= MASTER ================= */

            DB::raw('(SELECT COUNT(*) 
                FROM student_masters sm 
                WHERE sm.etablissement_id = e.id
            ) as master_total'),

            DB::raw('(SELECT COUNT(*) 
                FROM student_masters sm 
                WHERE sm.etablissement_id = e.id
                AND EXISTS (
                    SELECT 1 FROM payment_masters pm 
                    WHERE pm.student_id = sm.id
                )
            ) as master_paid'),

            DB::raw('(SELECT COALESCE(SUM(pm.montant_paye),0)
                FROM payment_masters pm
                JOIN student_masters sm2 ON sm2.id = pm.student_id
                WHERE sm2.etablissement_id = e.id
            ) as master_revenue'),

            /* ================= PASSERELLE ================= */

            DB::raw('(SELECT COUNT(*) 
                FROM student_passerelles sp 
                WHERE sp.etablissement_id = e.id
            ) as passerelle_total'),

            DB::raw('(SELECT COUNT(*) 
                FROM student_passerelles sp 
                WHERE sp.etablissement_id = e.id
                AND EXISTS (
                    SELECT 1 FROM payment_passerelles pp 
                    WHERE pp.student_id = sp.id
                )
            ) as passerelle_paid'),

            DB::raw('(SELECT COALESCE(SUM(pp.montant_paye),0)
                FROM payment_passerelles pp
                JOIN student_passerelles sp2 ON sp2.id = pp.student_id
                WHERE sp2.etablissement_id = e.id
            ) as passerelle_revenue'),

            /* ================= BACHELIER ================= */

            DB::raw('(SELECT COUNT(*) 
                FROM bacheliers b 
                WHERE b.etablissement_id = e.id
            ) as bachelier_total'),

            DB::raw('(SELECT COUNT(*) 
                FROM bacheliers b 
                WHERE b.etablissement_id = e.id
                AND EXISTS (
                    SELECT 1 FROM payment_bacheliers pb 
                    WHERE pb.student_id = b.id
                )
            ) as bachelier_paid'),

            DB::raw('(SELECT COALESCE(SUM(pb.montant_paye),0)
                FROM payment_bacheliers pb
                JOIN bacheliers b2 ON b2.id = pb.student_id
                WHERE b2.etablissement_id = e.id
            ) as bachelier_revenue'),

            /* ================= TOTAL REVENUE ================= */

            DB::raw('(
                COALESCE((SELECT SUM(pm.montant_paye)
                FROM payment_masters pm
                JOIN student_masters sm2 ON sm2.id = pm.student_id
                WHERE sm2.etablissement_id = e.id),0)

                +

                COALESCE((SELECT SUM(pp.montant_paye)
                FROM payment_passerelles pp
                JOIN student_passerelles sp2 ON sp2.id = pp.student_id
                WHERE sp2.etablissement_id = e.id),0)

                +

                COALESCE((SELECT SUM(pb.montant_paye)
                FROM payment_bacheliers pb
                JOIN bacheliers b2 ON b2.id = pb.student_id
                WHERE b2.etablissement_id = e.id),0)
            ) as total_revenue')

        )
        ->whereExists(function($query){
            $query->select(DB::raw(1))
                ->from('filieres')
                ->whereColumn('filieres.etablissement_id','e.id');
        })
        /* ⭐ SORT BY TOTAL REVENUE */
        ->orderByDesc('total_revenue')

        ->get();

        return view('sup-admin.payment.index',compact('etablissements'));
        
    }

    public function paymentFiliereMaster(Etablissement $etablissement)
    {

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

        return view('sup-admin.payment.indexMaster', compact('etablissement','filieres'));
    }

    public function paymentFiliereMasterStudents(Filiere $filiere, Request $request){
        
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
                    ->orWhere('CNE', 'like', "%$search%")
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

                $verificationLabel = '';

                if ($etudiant->verification == 0) {
                    $verificationLabel = '<span class="badge badge-warning">En cours de traitement</span>';
                } 
                elseif ($etudiant->verification == 1) {
                    $verificationLabel = '<span class="badge badge-success">Montant valide</span>';
                } 
                elseif ($etudiant->verification == 2) {
                    $verificationLabel = '<span class="badge badge-danger">Une information nécessite votre vérification</span>';
                }

                return [
                    'id'            => $etudiant->id,
                    'nom'           => $etudiant->nom,
                    'prenom'        => $etudiant->prenom,
                    'CIN'           => $etudiant->CIN,
                    'email'         => $etudiant->email,
                    'phone'         => $etudiant->phone,
                    'type_master'   => $etudiant->type_master,
                    'montant'       => $etudiant->montant_paye." DH",
                    'date_inscription' => $etudiant->date_inscription,
                    'montant_detecter' => $etudiant->montant_detecter !== null ? $etudiant->montant_detecter . " DH" : '<span class="badge bg-warning text-white">En attente</span>',
                    'verification' => $verificationLabel,
                    'student_id'    => $etudiant->student_id,
                    'etat_payment'  => '<span class="' . $badgeClass . '">' . $etudiant->etat_payment . '</span>',
                    'actions' => '<a href="'.route('sup-admin.payment.master.filiere.student.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('sup-admin.payment.indexMasterStudents',compact('etablissement','filiere'));
    }

    public function paymentFiliereMasterShowStudent(Filiere $filiere,$etudiant){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $multipleChoixFiliereMaster = auth()->user() && $etablissement->multiple_choix_filiere_master == 1;

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

        return view('sup-admin.payment.showStudentPaymentMaster',compact('multipleChoixFiliereMaster','filiere','etudiant','etablissement','payments'));
    }

    public function checkAutoReceiptMaster(PaymentMaster $payment, Request $request)
    {
        $request->validate([
            'montant_detecte' => 'required|numeric|min:0'
        ]);

        $montantDetecte = $request->montant_detecte;

        // Save detected amount
        $payment->montant_detecter = $montantDetecte;

        // Compare with expected payment amount
        if ((float)$payment->montant_paye === (float)$montantDetecte) {
            $payment->verification = 1; // Valid
        } else {
            $payment->verification = 2; // Mismatch
        }

        $payment->save();

        return response()->json([
            'success' => true,
            'verification' => $payment->verification,
            'montant' => $payment->montant_detecter,
            'message' => $payment->verification == 1
                ? 'Montant validé avec succès'
                : 'Montant différent du paiement attendu'
        ]);
    }

    public function paymentFiliereLicence(Etablissement $etablissement){

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


        return view('sup-admin.payment.indexPasserelle', compact('etablissement','filieres'));
    }

    public function paymentFiliereLicenceStudents(Filiere $filiere, Request $request){
        
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
                    ->orWhere('CNE', 'like', "%$search%")
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

                $verificationLabel = '';

                if ($etudiant->verification == 0) {
                    $verificationLabel = '<span class="badge badge-warning">En cours de traitement</span>';
                } 
                elseif ($etudiant->verification == 1) {
                    $verificationLabel = '<span class="badge badge-success">Montant valide</span>';
                } 
                elseif ($etudiant->verification == 2) {
                    $verificationLabel = '<span class="badge badge-danger">Une information nécessite votre vérification</span>';
                }

                return [
                    'id'            => $etudiant->id,
                    'nom'           => $etudiant->nom,
                    'prenom'        => $etudiant->prenom,
                    'CIN'           => $etudiant->CIN,
                    'email'         => $etudiant->email,
                    'phone'         => $etudiant->phone,
                    'montant'       => $etudiant->montant_paye." DH",
                    'date_inscription' => $etudiant->date_inscription,
                    'montant_detecter' => $etudiant->montant_detecter !== null ? $etudiant->montant_detecter . " DH" : '<span class="badge bg-warning text-white">En attente</span>',
                    'verification' => $verificationLabel,
                    'student_id'    => $etudiant->student_id,
                    'etat_payment'  => '<span class="' . $badgeClass . '">' . $etudiant->etat_payment . '</span>',
                    'actions' => '<a href="'.route('sup-admin.payment.licence.filiere.student.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('sup-admin.payment.indexLicenceStudents',compact('etablissement','filiere'));
    }

    public function paymentFiliereLicenceShowStudent(Filiere $filiere,$etudiant){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $multipleChoixFilierePasserelles = auth()->user() && $etablissement->multiple_choix_filiere_passerelle == 1;

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

        return view('sup-admin.payment.showStudentPaymentPasserelles',compact('multipleChoixFilierePasserelles','filiere','etudiant','etablissement','payments'));
    }

    public function checkAutoReceiptLicence(PaymentPasserelle $payment, Request $request)
    {
        $request->validate([
            'montant_detecte' => 'required|numeric|min:0'
        ]);

        $montantDetecte = $request->montant_detecte;

        // Save detected amount
        $payment->montant_detecter = $montantDetecte;

        // Compare with expected payment amount
        if ((float)$payment->montant_paye === (float)$montantDetecte) {
            $payment->verification = 1; // Valid
        } else {
            $payment->verification = 2; // Mismatch
        }

        $payment->save();

        return response()->json([
            'success' => true,
            'verification' => $payment->verification,
            'montant' => $payment->montant_detecter,
            'message' => $payment->verification == 1
                ? 'Montant validé avec succès'
                : 'Montant différent du paiement attendu'
        ]);
    }

    public function paymentFiliereBachelier(Etablissement $etablissement){

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


        return view('sup-admin.payment.indexBachelier', compact('etablissement','filieres'));
    }

    public function paymentFiliereBachelierStudents(Filiere $filiere, Request $request){
        
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
                    ->orWhere('CNE', 'like', "%$search%")
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

                $verificationLabel = '';

                if ($etudiant->verification == 0) {
                    $verificationLabel = '<span class="badge badge-warning">En cours de traitement</span>';
                } 
                elseif ($etudiant->verification == 1) {
                    $verificationLabel = '<span class="badge badge-success">Montant valide</span>';
                } 
                elseif ($etudiant->verification == 2) {
                    $verificationLabel = '<span class="badge badge-danger">Une information nécessite votre vérification</span>';
                }

                return [
                    'id'            => $etudiant->id,
                    'nom'           => $etudiant->nom,
                    'prenom'        => $etudiant->prenom,
                    'CIN'           => $etudiant->CIN,
                    'email'         => $etudiant->email,
                    'phone'         => $etudiant->phone,
                    'semestre'      => $etudiant->semestre,
                    'montant'       => $etudiant->montant_paye." DH",
                    'date_inscription' => $etudiant->date_inscription,
                    'montant_detecter' => $etudiant->montant_detecter !== null ? $etudiant->montant_detecter . " DH" : '<span class="badge bg-warning text-white">En attente</span>',
                    'verification' => $verificationLabel,
                    'student_id'    => $etudiant->student_id,
                    'etat_payment'  => '<span class="' . $badgeClass . '">' . $etudiant->etat_payment . '</span>',
                    'actions' => '<a href="'.route('sup-admin.payment.licence.filiere.student.show', ['filiere' => $filiere->id,'etudiant' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('sup-admin.payment.indexBachelierStudents',compact('etablissement','filiere'));
    }

    public function paymentFiliereBachelierShowStudent(Filiere $filiere,$etudiant){
        $filiere->load('etablissement');
        $etablissement = $filiere->etablissement;

        $multipleChoixFiliereBacheliers = auth()->user() && $etablissement->multiple_choix_filiere == 1;

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

        return view('sup-admin.payment.showStudentPaymentBacheliers',compact('multipleChoixFiliereBacheliers','filiere','etudiant','etablissement','payments'));
    }

    public function checkAutoReceiptBachelier(PaymentBacheliers $payment, Request $request)
    {
        $request->validate([
            'montant_detecte' => 'required|numeric|min:0'
        ]);

        $montantDetecte = $request->montant_detecte;

        // Save detected amount
        $payment->montant_detecter = $montantDetecte;

        // Compare with expected payment amount
        if ((float)$payment->montant_paye === (float)$montantDetecte) {
            $payment->verification = 1; // Valid
        } else {
            $payment->verification = 2; // Mismatch
        }

        $payment->save();

        return response()->json([
            'success' => true,
            'verification' => $payment->verification,
            'montant' => $payment->montant_detecter,
            'message' => $payment->verification == 1
                ? 'Montant validé avec succès'
                : 'Montant différent du paiement attendu'
        ]);
    }


    public function checkReceiptMasterAllStudents()
    {
        $total = PaymentMaster::where('verification', 0)->count();

        PaymentMaster::where('verification', 0)
            ->chunk(50, function ($students) {

                foreach ($students as $student) {

                    CheckMasterReceiptJob::dispatch($student);

                }

            });

        return response()->json([
            'status' => true,
            'message' => 'Processing started',
            'total' => $total
        ]);
    }

    public function checkReceiptMasterProgress()
    {
        // Total students involved in this verification process
        $total = PaymentMaster::count();

        // Verified successfully
        $validated = PaymentMaster::where('verification', 1)->count();

        // Need manual verification
        $manual = PaymentMaster::where('verification', 2)->count();

        // Still pending (not processed yet)
        $pending = PaymentMaster::where('verification', 0)->count();

        // Calculate analysed count
        $analysed = $validated + $manual;

        // Percentage calculation
        $percentage = $total > 0 
            ? round(($analysed / $total) * 100, 2)
            : 0;

        return response()->json([
            'total'      => $total,
            'validated'  => $validated,
            'manual'     => $manual,
            'pending'    => $pending,
            'analysed'   => $analysed,
            'percentage' => $percentage,
            'finished'   => $pending == 0
        ]);
    }


    public function checkReceiptMaster(PaymentMaster $payment)
    {
        try {

        if ($payment->etat_payment === "Complete(Fonctionnaire à l'UH1)") {
                $payment->verification = 1;
                $payment->montant_detecter = 0;
                $payment->save();

                    return response()->json([
                        'status'          => abs(0 - 0) <= 0.5,
                        'expected_amount' => 0,
                        'detected_amount' => 0,
                        'raw_text'        => "Success"
                    ]);
        }

            $expectedAmount = round((float)$payment->montant_paye, 2);

            /*
            =====================================================
            1️⃣ Locate Image
            =====================================================
            */
            $imagePath = storage_path('app/public/' . ltrim($payment->document, '/'));
            if (!file_exists($imagePath)) {
                $imagePath = public_path($payment->document);
            }

            if (!file_exists($imagePath)) {
                return ['status'=>false,'message'=>'Image not found'];
            }

            /*
            =====================================================
            1.5️⃣ Enhance Image For Better OCR
            =====================================================
            */

            $enhancedPath = storage_path('app/temp_ocr_' . time() . '.png');

            $command = "convert "
                . escapeshellarg($imagePath)
                . " -colorspace Gray"
                . " -density 300"
                . " -sharpen 0x1"
                . " -contrast"
                . " -normalize"
                . " -threshold 65%"
                . " "
                . escapeshellarg($enhancedPath);

            exec($command);

            // Use enhanced image
            if (file_exists($enhancedPath)) {
                $imagePath = $enhancedPath;
            }

            /*
            =====================================================
            2️⃣ OCR CALL
            =====================================================
            */
            $response = Http::timeout(60)
                ->retry(2, 2000)
                ->asMultipart()
                ->post('https://api.ocr.space/parse/image', [
                    'apikey'    => env('OCR_SPACE_API_KEY'),
                    'language'  => 'fre',
                    'OCREngine' => '2',
                    'file'      => fopen($imagePath, 'r')
                ]);

            $text = $response->json()['ParsedResults'][0]['ParsedText'] ?? '';

            // Clean OCR text
            $text = trim($text);

            // Normalize common OCR mistakes
            $text = preg_replace('/\bI(?=\d)/', '1', $text);
            $text = preg_replace('/\bO(?=\d)/', '0', $text);
            $text = str_replace('|', '1', $text);

            if (!$text) {
                return ['status'=>false,'message'=>'OCR failed'];
            }

            // I5 -> 15
            $text = preg_replace('/\bI(?=\d)/', '1', $text);

            // O5 -> 05
            $text = preg_replace('/\bO(?=\d)/', '0', $text);

            // 0694|90128 -> 0694190128
            $text = str_replace('|', '1', $text);

            $textLower = strtolower($text);
            // OCR common mistakes
            $textLower = str_replace([
                'millc',
                'mili',
                'milié',
                'milc'
            ], 'mille', $textLower);
            
            $lines = preg_split('/\r\n|\r|\n/', $textLower);

            /*
            =====================================================
            DIRECT AMOUNT EXTRACTION AFTER "MONTANT"
            =====================================================
            */

            for ($i = 0; $i < count($lines); $i++) {

                if (strpos($lines[$i], 'montant') !== false) {

                    for ($j = 1; $j <= 3; $j++) {

                        if (!isset($lines[$i+$j])) continue;

                        if (preg_match('/([\d\.,]+)/', $lines[$i+$j], $m)) {

                            $value = str_replace([',',' '], '', $m[1]);
                            $detectedAmount = floatval($value);

                            if ($detectedAmount > 1000 && $detectedAmount < 200000) {

                                $payment->montant_detecter = $detectedAmount;

                                $tolerance = max(1, $expectedAmount * 0.02);

                                if (abs($detectedAmount - $expectedAmount) <= $tolerance) {
                                    $payment->verification = 1;
                                } else {
                                    $payment->verification = 2;
                                }

                                $payment->save();

                                return [
                                    'status' => abs($detectedAmount - $expectedAmount) <= $tolerance,
                                    'expected_amount' => $expectedAmount,
                                    'detected_amount' => $detectedAmount,
                                    'raw_text' => $text
                                ];
                            }
                        }
                    }
                }
            }

            $candidates = [];

            /*
            =====================================================
            BANK FIELD DETECTION (BP DH)
            =====================================================
            */

            if (preg_match('/bp\s*dh.*?(\d{4,6})/i', $textLower, $match)) {

                $value = $this->normalizeMoroccanNumber($match[1]);

                $candidates[] = [
                    'value' => $value,
                    'score' => 250
                ];
            }

            /*
            =====================================================
            3️⃣ Collect & Score Numeric Candidates
            =====================================================
            */

            foreach ($lines as $line) {

                if (!preg_match_all('/\d[\d\s\.,]*\d/', $line, $matches)) {
                    continue;
                }

                foreach ($matches[0] as $raw) {

                    $token = trim($raw);

                    // Reject if attached directly to letters (1401V)
                    if (preg_match('/[a-z]'.$token.'|'.$token.'[a-z]/i', $line)) {
                        continue;
                    }

                    $clean = str_replace(' ', '', $token);

                    // Reject dates (02/02/2026, 02-02-26, 02.02.26)
                    if (preg_match('/^\d{1,2}[.\-\/]\d{1,2}[.\-\/]\d{2,4}$/', $clean)) {
                        continue;
                    }

                    // Reject years like 2025
                    if (preg_match('/^(19|20)\d{2}$/', $clean)) {
                        continue;
                    }

                    $value = $this->normalizeMoroccanNumber($clean);

                    if ($value < 1000 || $value > 200000) {
                        continue;
                    }

                    /*
                    =========================
                    SCORING SYSTEM
                    =========================
                    */

                    $score = 0;

                    /*
                    =====================================
                    BANK DOCUMENT INTELLIGENCE BOOST
                    =====================================
                    */

                    $bankKeywords = [
                        'montant',
                        'virement',
                        'somme',
                        'total',
                        'dh'
                    ];

                    foreach ($bankKeywords as $keyword) {
                        if (strpos($line,$keyword)!==false) {
                            $score += 200;
                        }
                    }

                    /*
                    Strong priority if amount appears near "montant"
                    */

                    if (preg_match('/montant.{0,20}\d/', $line)) {
                        $score += 300;
                    }

                    /*
                    Prevent IBAN / account numbers from being detected
                    */

                    if (preg_match('/(rib|compte|iban|code|agence|réf|ref)/i',$line)) {
                        $score -= 300;
                    }

                    if (strpos($line,'montant')!==false) $score+=50;
                    if (strpos($line,'somme')!==false) $score+=40;
                    if (strpos($line,'virement')!==false) $score+=30;
                    if (strpos($line,'payer')!==false) $score+=25;
                    if (strpos($line,'dh')!==false) $score+=20;

                    if (preg_match('/(rib|compte|capital|ref|réf)/',$line)) $score-=100;
                    if (strpos($line,'date')!==false) $score-=80;
                    if (strpos($line,'année')!==false) $score-=80;

                    $diff = abs($value - $expectedAmount);

                    // Strong priority if close to expected payment
                    if ($diff < 50) {
                        $score += 200;
                    }

                    if ($diff < 500) {
                        $score += 120;
                    }

                    // Percentage based tolerance (BEST PRACTICE)
                    $percentageDiff = ($diff / max($expectedAmount, 1)) * 100;

                    if ($percentageDiff <= 2) {
                        $score += 150;
                    }

                    $candidates[] = [
                        'value'=>$value,
                        'score'=>$score
                    ];
                }
            }

            /*
            =====================================================
            4️⃣ Written French Fallback
            =====================================================
            */

            if (preg_match('/quin.{0,3}ze/i', $textLower)) {

                if (preg_match('/mil{1,2}[ei]/i', $textLower)) {

                    $candidates[] = [
                        'value' => 15000,
                        'score' => 500
                    ];
                }

            }

            // =====================================
            // Frequency Voting (Fix OCR random numbers)
            // =====================================

            $amountFrequency = [];

            foreach ($candidates as $candidate) {

                $v = (string)round($candidate['value']);

                if (!isset($amountFrequency[$v])) {
                    $amountFrequency[$v] = 0;
                }

                $amountFrequency[$v] += $candidate['score'];
            }

            if (!empty($amountFrequency)) {
                arsort($amountFrequency);
                $detectedAmount = (float)array_key_first($amountFrequency);
            }

            /*
            =====================================================
            5️⃣ Pick Best Candidate
            =====================================================
            */

            if (empty($candidates)) {
                return [
                    'status'=>false,
                    'expected_amount'=>$expectedAmount,
                    'detected_amount'=>0,
                    'raw_text'=>$text
                ];
            }

            usort($candidates,function($a,$b){
                return $b['score'] <=> $a['score'];
            });

            /*
            =====================================
            PAYMENT PROBABILITY BOOST
            =====================================
            */

            foreach ($candidates as &$candidate) {

                $value = $candidate['value'];

                $diff = abs($value - $expectedAmount);

                if ($diff < 30) $candidate['score'] += 500;
                if ($diff < 100) $candidate['score'] += 300;
                if ($diff < 1000) $candidate['score'] += 150;
            }

            /*
            =====================================
            DECIMAL STABILIZATION ENGINE
            =====================================
            */

            foreach ($candidates as &$c) {

                // Force decimal rounding normalization
                $c['value'] = $this->stabilizeAmount($c['value']);

                // If very close to expected → boost score
                if (abs($c['value'] - $expectedAmount) < 20) {
                    $c['score'] += 800;
                }
            }

            usort($candidates,function($a,$b){
                return $b['score'] <=> $a['score'];
            });

            $detectedAmount = $this->stabilizeAmount($candidates[0]['value']);

            $payment->montant_detecter = $detectedAmount;

            $tolerance = max(1, $expectedAmount * 0.02);

            if (abs($detectedAmount - $expectedAmount) <= $tolerance) {
                $payment->verification = 1;
            } else {
                $payment->verification = 2;
            }

            $payment->save();

            /*
            =====================================================
            6️⃣ Final Validation
            =====================================================
            */

            return response()->json([
                'status'          => abs($detectedAmount - $expectedAmount) <= 0.5,
                'expected_amount' => $expectedAmount,
                'detected_amount' => $detectedAmount,
                'raw_text'        => $text
            ]);

        } catch (\Exception $e) {
            return ['status'=>false,'message'=>$e->getMessage()];
        }
    }
    
    private function stabilizeAmount(float $value)
    {
        return round($value, 2);
    }

    private function normalizeMoroccanNumber($num)
    {
        if (strpos($num, ',')!==false && strpos($num,'.')!==false) {
            $num=str_replace('.','',$num);
            $num=str_replace(',','.',$num);
            return (float)$num;
        }

        if (strpos($num, ',')!==false) {
            return (float)str_replace(',','.',$num);
        }

        if (substr_count($num,'.')>1) {
            return (float)str_replace('.','',$num);
        }

        return (float)$num;
    }


    public function checkReceiptLicenceAllStudents()
    {
        $total = PaymentPasserelle::where('verification', 0)->count();

        PaymentPasserelle::where('verification', 0)
            ->chunk(50, function ($students) {

                foreach ($students as $student) {

                    CheckLicenceReceiptJob::dispatch($student);

                }

            });

        return response()->json([
            'status' => true,
            'message' => 'Processing started',
            'total' => $total
        ]);
    }

    public function checkReceiptLicenceProgress()
    {
        // Total students involved in this verification process
        $total = PaymentPasserelle::count();

        // Verified successfully
        $validated = PaymentPasserelle::where('verification', 1)->count();

        // Need manual verification
        $manual = PaymentPasserelle::where('verification', 2)->count();

        // Still pending (not processed yet)
        $pending = PaymentPasserelle::where('verification', 0)->count();

        // Calculate analysed count
        $analysed = $validated + $manual;

        // Percentage calculation
        $percentage = $total > 0 
            ? round(($analysed / $total) * 100, 2)
            : 0;

        return response()->json([
            'total'      => $total,
            'validated'  => $validated,
            'manual'     => $manual,
            'pending'    => $pending,
            'analysed'   => $analysed,
            'percentage' => $percentage,
            'finished'   => $pending == 0
        ]);
    }

    public function checkReceiptLicence(PaymentPasserelle $payment)
    {
        try {

        if ($payment->etat_payment === "Complete(Fonctionnaire à l'UH1)") {
                $payment->verification = 1;
                $payment->montant_detecter = 0;
                $payment->save();

                    return response()->json([
                        'status'          => abs(0 - 0) <= 0.5,
                        'expected_amount' => 0,
                        'detected_amount' => 0,
                        'raw_text'        => "Success"
                    ]);
        }

            $expectedAmount = round((float)$payment->montant_paye, 2);

            /*
            =====================================================
            1️⃣ Locate Image
            =====================================================
            */
            $imagePath = storage_path('app/public/' . ltrim($payment->document, '/'));
            if (!file_exists($imagePath)) {
                $imagePath = public_path($payment->document);
            }

            if (!file_exists($imagePath)) {
                return ['status'=>false,'message'=>'Image not found'];
            }

            /*
            =====================================================
            1.5️⃣ Enhance Image For Better OCR
            =====================================================
            */

            $enhancedPath = storage_path('app/temp_ocr_' . time() . '.png');

            $command = "convert "
                . escapeshellarg($imagePath)
                . " -colorspace Gray"
                . " -density 300"
                . " -sharpen 0x1"
                . " -contrast"
                . " -normalize"
                . " -threshold 65%"
                . " "
                . escapeshellarg($enhancedPath);

            exec($command);

            // Use enhanced image
            if (file_exists($enhancedPath)) {
                $imagePath = $enhancedPath;
            }

            /*
            =====================================================
            2️⃣ OCR CALL
            =====================================================
            */
            $response = Http::timeout(60)
                ->retry(2, 2000)
                ->asMultipart()
                ->post('https://api.ocr.space/parse/image', [
                    'apikey'    => env('OCR_SPACE_API_KEY'),
                    'language'  => 'fre',
                    'OCREngine' => '2',
                    'file'      => fopen($imagePath, 'r')
                ]);

            $text = $response->json()['ParsedResults'][0]['ParsedText'] ?? '';

            // Clean OCR text
            $text = trim($text);

            // Normalize common OCR mistakes
            $text = preg_replace('/\bI(?=\d)/', '1', $text);
            $text = preg_replace('/\bO(?=\d)/', '0', $text);
            $text = str_replace('|', '1', $text);

            if (!$text) {
                return ['status'=>false,'message'=>'OCR failed'];
            }

            // I5 -> 15
            $text = preg_replace('/\bI(?=\d)/', '1', $text);

            // O5 -> 05
            $text = preg_replace('/\bO(?=\d)/', '0', $text);

            // 0694|90128 -> 0694190128
            $text = str_replace('|', '1', $text);

            $textLower = strtolower($text);
            // OCR common mistakes
            $textLower = str_replace([
                'millc',
                'mili',
                'milié',
                'milc'
            ], 'mille', $textLower);
            $lines = preg_split('/\r\n|\r|\n/', $textLower);

            /*
            =====================================================
            DIRECT AMOUNT EXTRACTION AFTER "MONTANT"
            =====================================================
            */

            for ($i = 0; $i < count($lines); $i++) {

                if (strpos($lines[$i], 'montant') !== false) {

                    for ($j = 1; $j <= 3; $j++) {

                        if (!isset($lines[$i+$j])) continue;

                        if (preg_match('/([\d\.,]+)/', $lines[$i+$j], $m)) {

                            $value = str_replace([',',' '], '', $m[1]);
                            $detectedAmount = floatval($value);

                            if ($detectedAmount > 1000 && $detectedAmount < 200000) {

                                $payment->montant_detecter = $detectedAmount;

                                $tolerance = max(1, $expectedAmount * 0.02);

                                if (abs($detectedAmount - $expectedAmount) <= $tolerance) {
                                    $payment->verification = 1;
                                } else {
                                    $payment->verification = 2;
                                }

                                $payment->save();

                                return [
                                    'status' => abs($detectedAmount - $expectedAmount) <= $tolerance,
                                    'expected_amount' => $expectedAmount,
                                    'detected_amount' => $detectedAmount,
                                    'raw_text' => $text
                                ];
                            }
                        }
                    }
                }
            }

            $candidates = [];

            /*
            =====================================================
            BANK FIELD DETECTION (BP DH)
            =====================================================
            */

            if (preg_match('/bp\s*dh.*?(\d{4,6})/i', $textLower, $match)) {

                $value = $this->normalizeMoroccanNumber($match[1]);

                $candidates[] = [
                    'value' => $value,
                    'score' => 250
                ];
            }

            /*
            =====================================================
            3️⃣ Collect & Score Numeric Candidates
            =====================================================
            */

            foreach ($lines as $line) {

                if (!preg_match_all('/\d[\d\s\.,]*\d/', $line, $matches)) {
                    continue;
                }

                foreach ($matches[0] as $raw) {

                    $token = trim($raw);

                    // Reject if attached directly to letters (1401V)
                    if (preg_match('/[a-z]'.$token.'|'.$token.'[a-z]/i', $line)) {
                        continue;
                    }

                    $clean = str_replace(' ', '', $token);

                    // Reject dates (02/02/2026, 02-02-26, 02.02.26)
                    if (preg_match('/^\d{1,2}[.\-\/]\d{1,2}[.\-\/]\d{2,4}$/', $clean)) {
                        continue;
                    }

                    // Reject years like 2025
                    if (preg_match('/^(19|20)\d{2}$/', $clean)) {
                        continue;
                    }

                    $value = $this->normalizeMoroccanNumber($clean);

                    if ($value < 1000 || $value > 200000) {
                        continue;
                    }

                    /*
                    =========================
                    SCORING SYSTEM
                    =========================
                    */

                    $score = 0;

                    /*
                    =====================================
                    BANK DOCUMENT INTELLIGENCE BOOST
                    =====================================
                    */

                    $bankKeywords = [
                        'montant',
                        'virement',
                        'somme',
                        'total',
                        'dh'
                    ];

                    foreach ($bankKeywords as $keyword) {
                        if (strpos($line,$keyword)!==false) {
                            $score += 200;
                        }
                    }

                    /*
                    Strong priority if amount appears near "montant"
                    */

                    if (preg_match('/montant.{0,20}\d/', $line)) {
                        $score += 300;
                    }

                    /*
                    Prevent IBAN / account numbers from being detected
                    */

                    if (preg_match('/(rib|compte|iban|code|agence|réf|ref)/i',$line)) {
                        $score -= 300;
                    }

                    if (strpos($line,'montant')!==false) $score+=50;
                    if (strpos($line,'somme')!==false) $score+=40;
                    if (strpos($line,'virement')!==false) $score+=30;
                    if (strpos($line,'payer')!==false) $score+=25;
                    if (strpos($line,'dh')!==false) $score+=20;

                    if (preg_match('/(rib|compte|capital|ref|réf)/',$line)) $score-=100;
                    if (strpos($line,'date')!==false) $score-=80;
                    if (strpos($line,'année')!==false) $score-=80;

                    $diff = abs($value - $expectedAmount);

                    // Strong priority if close to expected payment
                    if ($diff < 50) {
                        $score += 200;
                    }

                    if ($diff < 500) {
                        $score += 120;
                    }

                    // Percentage based tolerance (BEST PRACTICE)
                    $percentageDiff = ($diff / max($expectedAmount, 1)) * 100;

                    if ($percentageDiff <= 2) {
                        $score += 150;
                    }

                    $candidates[] = [
                        'value'=>$value,
                        'score'=>$score
                    ];
                }
            }

            /*
            =====================================================
            4️⃣ Written French Fallback
            =====================================================
            */

            if (preg_match('/quin.{0,3}ze/i', $textLower)) {

                if (preg_match('/mil{1,2}[ei]/i', $textLower)) {

                    $candidates[] = [
                        'value' => 15000,
                        'score' => 500
                    ];
                }

            }

            // =====================================
            // Frequency Voting (Fix OCR random numbers)
            // =====================================

            $amountFrequency = [];

            foreach ($candidates as $candidate) {

                $v = (string)round($candidate['value']);

                if (!isset($amountFrequency[$v])) {
                    $amountFrequency[$v] = 0;
                }

                $amountFrequency[$v] += $candidate['score'];
            }

            if (!empty($amountFrequency)) {
                arsort($amountFrequency);
                $detectedAmount = (float)array_key_first($amountFrequency);
            }

            /*
            =====================================================
            5️⃣ Pick Best Candidate
            =====================================================
            */

            if (empty($candidates)) {
                return [
                    'status'=>false,
                    'expected_amount'=>$expectedAmount,
                    'detected_amount'=>0,
                    'raw_text'=>$text
                ];
            }

            usort($candidates,function($a,$b){
                return $b['score'] <=> $a['score'];
            });

            /*
            =====================================
            PAYMENT PROBABILITY BOOST
            =====================================
            */

            foreach ($candidates as &$candidate) {

                $value = $candidate['value'];

                $diff = abs($value - $expectedAmount);

                if ($diff < 30) $candidate['score'] += 500;
                if ($diff < 100) $candidate['score'] += 300;
                if ($diff < 1000) $candidate['score'] += 150;
            }

            /*
            =====================================
            DECIMAL STABILIZATION ENGINE
            =====================================
            */

            foreach ($candidates as &$c) {

                // Force decimal rounding normalization
                $c['value'] = $this->stabilizeAmount($c['value']);

                // If very close to expected → boost score
                if (abs($c['value'] - $expectedAmount) < 20) {
                    $c['score'] += 800;
                }
            }

            usort($candidates,function($a,$b){
                return $b['score'] <=> $a['score'];
            });

            $detectedAmount = $this->stabilizeAmount($candidates[0]['value']);

            $payment->montant_detecter = $detectedAmount;

            $tolerance = max(1, $expectedAmount * 0.02);

            if (abs($detectedAmount - $expectedAmount) <= $tolerance) {
                $payment->verification = 1;
            } else {
                $payment->verification = 2;
            }

            $payment->save();

            /*
            =====================================================
            6️⃣ Final Validation
            =====================================================
            */

            return response()->json([
                'status'          => abs($detectedAmount - $expectedAmount) <= 0.5,
                'expected_amount' => $expectedAmount,
                'detected_amount' => $detectedAmount,
                'raw_text'        => $text
            ]);

        } catch (\Exception $e) {
            return ['status'=>false,'message'=>$e->getMessage()];
        }
    }

    public function checkReceiptBachelierAllStudents()
    {
        $total = PaymentBacheliers::where('verification', 0)->count();

        PaymentBacheliers::where('verification', 0)
            ->chunk(50, function ($students) {

                foreach ($students as $student) {

                    CheckBachelierReceiptJob::dispatch($student);

                }

            });

        return response()->json([
            'status' => true,
            'message' => 'Processing started',
            'total' => $total
        ]);
    }

    public function checkReceiptBachelierProgress()
    {
        // Total students involved in this verification process
        $total = PaymentBacheliers::count();

        // Verified successfully
        $validated = PaymentBacheliers::where('verification', 1)->count();

        // Need manual verification
        $manual = PaymentBacheliers::where('verification', 2)->count();

        // Still pending (not processed yet)
        $pending = PaymentBacheliers::where('verification', 0)->count();

        // Calculate analysed count
        $analysed = $validated + $manual;

        // Percentage calculation
        $percentage = $total > 0 
            ? round(($analysed / $total) * 100, 2)
            : 0;

        return response()->json([
            'total'      => $total,
            'validated'  => $validated,
            'manual'     => $manual,
            'pending'    => $pending,
            'analysed'   => $analysed,
            'percentage' => $percentage,
            'finished'   => $pending == 0
        ]);
    }

    public function checkReceiptBachelier(PaymentBacheliers $payment)
    {
        try {

        if ($payment->etat_payment === "Complete(Fonctionnaire à l'UH1)") {
                $payment->verification = 1;
                $payment->montant_detecter = 0;
                $payment->save();

                    return response()->json([
                        'status'          => abs(0 - 0) <= 0.5,
                        'expected_amount' => 0,
                        'detected_amount' => 0,
                        'raw_text'        => "Success"
                    ]);
        }

            $expectedAmount = round((float)$payment->montant_paye, 2);

            /*
            =====================================================
            1️⃣ Locate Image
            =====================================================
            */
            $imagePath = storage_path('app/public/' . ltrim($payment->document, '/'));
            if (!file_exists($imagePath)) {
                $imagePath = public_path($payment->document);
            }

            if (!file_exists($imagePath)) {
                return ['status'=>false,'message'=>'Image not found'];
            }

            /*
            =====================================================
            1.5️⃣ Enhance Image For Better OCR
            =====================================================
            */

            $enhancedPath = storage_path('app/temp_ocr_' . time() . '.png');

            $command = "convert "
                . escapeshellarg($imagePath)
                . " -colorspace Gray"
                . " -density 300"
                . " -sharpen 0x1"
                . " -contrast"
                . " -normalize"
                . " -threshold 65%"
                . " "
                . escapeshellarg($enhancedPath);

            exec($command);

            // Use enhanced image
            if (file_exists($enhancedPath)) {
                $imagePath = $enhancedPath;
            }

            /*
            =====================================================
            2️⃣ OCR CALL
            =====================================================
            */
            $response = Http::timeout(60)
                ->retry(2, 2000)
                ->asMultipart()
                ->post('https://api.ocr.space/parse/image', [
                    'apikey'    => env('OCR_SPACE_API_KEY'),
                    'language'  => 'fre',
                    'OCREngine' => '2',
                    'file'      => fopen($imagePath, 'r')
                ]);

            $text = $response->json()['ParsedResults'][0]['ParsedText'] ?? '';

            // Clean OCR text
            $text = trim($text);

            // Normalize common OCR mistakes
            $text = preg_replace('/\bI(?=\d)/', '1', $text);
            $text = preg_replace('/\bO(?=\d)/', '0', $text);
            $text = str_replace('|', '1', $text);

            if (!$text) {
                return ['status'=>false,'message'=>'OCR failed'];
            }

            // I5 -> 15
            $text = preg_replace('/\bI(?=\d)/', '1', $text);

            // O5 -> 05
            $text = preg_replace('/\bO(?=\d)/', '0', $text);

            // 0694|90128 -> 0694190128
            $text = str_replace('|', '1', $text);

            $textLower = strtolower($text);
            // OCR common mistakes
            $textLower = str_replace([
                'millc',
                'mili',
                'milié',
                'milc'
            ], 'mille', $textLower);
            
            $lines = preg_split('/\r\n|\r|\n/', $textLower);

            /*
            =====================================================
            DIRECT AMOUNT EXTRACTION AFTER "MONTANT"
            =====================================================
            */

            for ($i = 0; $i < count($lines); $i++) {

                if (strpos($lines[$i], 'montant') !== false) {

                    for ($j = 1; $j <= 3; $j++) {

                        if (!isset($lines[$i+$j])) continue;

                        if (preg_match('/([\d\.,]+)/', $lines[$i+$j], $m)) {

                            $value = str_replace([',',' '], '', $m[1]);
                            $detectedAmount = floatval($value);

                            if ($detectedAmount > 1000 && $detectedAmount < 200000) {

                                $payment->montant_detecter = $detectedAmount;

                                $tolerance = max(1, $expectedAmount * 0.02);

                                if (abs($detectedAmount - $expectedAmount) <= $tolerance) {
                                    $payment->verification = 1;
                                } else {
                                    $payment->verification = 2;
                                }

                                $payment->save();

                                return [
                                    'status' => abs($detectedAmount - $expectedAmount) <= $tolerance,
                                    'expected_amount' => $expectedAmount,
                                    'detected_amount' => $detectedAmount,
                                    'raw_text' => $text
                                ];
                            }
                        }
                    }
                }
            }

            $candidates = [];

            /*
            =====================================================
            BANK FIELD DETECTION (BP DH)
            =====================================================
            */

            if (preg_match('/bp\s*dh.*?(\d{4,6})/i', $textLower, $match)) {

                $value = $this->normalizeMoroccanNumber($match[1]);

                $candidates[] = [
                    'value' => $value,
                    'score' => 250
                ];
            }

            /*
            =====================================================
            3️⃣ Collect & Score Numeric Candidates
            =====================================================
            */

            foreach ($lines as $line) {

                if (!preg_match_all('/\d[\d\s\.,]*\d/', $line, $matches)) {
                    continue;
                }

                foreach ($matches[0] as $raw) {

                    $token = trim($raw);

                    // Reject if attached directly to letters (1401V)
                    if (preg_match('/[a-z]'.$token.'|'.$token.'[a-z]/i', $line)) {
                        continue;
                    }

                    $clean = str_replace(' ', '', $token);

                    // Reject dates (02/02/2026, 02-02-26, 02.02.26)
                    if (preg_match('/^\d{1,2}[.\-\/]\d{1,2}[.\-\/]\d{2,4}$/', $clean)) {
                        continue;
                    }

                    // Reject years like 2025
                    if (preg_match('/^(19|20)\d{2}$/', $clean)) {
                        continue;
                    }

                    $value = $this->normalizeMoroccanNumber($clean);

                    if ($value < 1000 || $value > 200000) {
                        continue;
                    }

                    /*
                    =========================
                    SCORING SYSTEM
                    =========================
                    */

                    $score = 0;

                    /*
                    =====================================
                    BANK DOCUMENT INTELLIGENCE BOOST
                    =====================================
                    */

                    $bankKeywords = [
                        'montant',
                        'virement',
                        'somme',
                        'total',
                        'dh'
                    ];

                    foreach ($bankKeywords as $keyword) {
                        if (strpos($line,$keyword)!==false) {
                            $score += 200;
                        }
                    }

                    /*
                    Strong priority if amount appears near "montant"
                    */

                    if (preg_match('/montant.{0,20}\d/', $line)) {
                        $score += 300;
                    }

                    /*
                    Prevent IBAN / account numbers from being detected
                    */

                    if (preg_match('/(rib|compte|iban|code|agence|réf|ref)/i',$line)) {
                        $score -= 300;
                    }

                    if (strpos($line,'montant')!==false) $score+=50;
                    if (strpos($line,'somme')!==false) $score+=40;
                    if (strpos($line,'virement')!==false) $score+=30;
                    if (strpos($line,'payer')!==false) $score+=25;
                    if (strpos($line,'dh')!==false) $score+=20;

                    if (preg_match('/(rib|compte|capital|ref|réf)/',$line)) $score-=100;
                    if (strpos($line,'date')!==false) $score-=80;
                    if (strpos($line,'année')!==false) $score-=80;

                    $diff = abs($value - $expectedAmount);

                    // Strong priority if close to expected payment
                    if ($diff < 50) {
                        $score += 200;
                    }

                    if ($diff < 500) {
                        $score += 120;
                    }

                    // Percentage based tolerance (BEST PRACTICE)
                    $percentageDiff = ($diff / max($expectedAmount, 1)) * 100;

                    if ($percentageDiff <= 2) {
                        $score += 150;
                    }

                    $candidates[] = [
                        'value'=>$value,
                        'score'=>$score
                    ];
                }
            }

            /*
            =====================================================
            4️⃣ Written French Fallback
            =====================================================
            */

            if (preg_match('/quin.{0,3}ze/i', $textLower)) {

                if (preg_match('/mil{1,2}[ei]/i', $textLower)) {

                    $candidates[] = [
                        'value' => 15000,
                        'score' => 500
                    ];
                }

            }

            // =====================================
            // Frequency Voting (Fix OCR random numbers)
            // =====================================

            $amountFrequency = [];

            foreach ($candidates as $candidate) {

                $v = (string)round($candidate['value']);

                if (!isset($amountFrequency[$v])) {
                    $amountFrequency[$v] = 0;
                }

                $amountFrequency[$v] += $candidate['score'];
            }

            if (!empty($amountFrequency)) {
                arsort($amountFrequency);
                $detectedAmount = (float)array_key_first($amountFrequency);
            }

            /*
            =====================================================
            5️⃣ Pick Best Candidate
            =====================================================
            */

            if (empty($candidates)) {
                return [
                    'status'=>false,
                    'expected_amount'=>$expectedAmount,
                    'detected_amount'=>0,
                    'raw_text'=>$text
                ];
            }

            usort($candidates,function($a,$b){
                return $b['score'] <=> $a['score'];
            });

            /*
            =====================================
            PAYMENT PROBABILITY BOOST
            =====================================
            */

            foreach ($candidates as &$candidate) {

                $value = $candidate['value'];

                $diff = abs($value - $expectedAmount);

                if ($diff < 30) $candidate['score'] += 500;
                if ($diff < 100) $candidate['score'] += 300;
                if ($diff < 1000) $candidate['score'] += 150;
            }

            /*
            =====================================
            DECIMAL STABILIZATION ENGINE
            =====================================
            */

            foreach ($candidates as &$c) {

                // Force decimal rounding normalization
                $c['value'] = $this->stabilizeAmount($c['value']);

                // If very close to expected → boost score
                if (abs($c['value'] - $expectedAmount) < 20) {
                    $c['score'] += 800;
                }
            }

            usort($candidates,function($a,$b){
                return $b['score'] <=> $a['score'];
            });

            $detectedAmount = $this->stabilizeAmount($candidates[0]['value']);

            $payment->montant_detecter = $detectedAmount;

            $tolerance = max(1, $expectedAmount * 0.02);

            if (abs($detectedAmount - $expectedAmount) <= $tolerance) {
                $payment->verification = 1;
            } else {
                $payment->verification = 2;
            }

            $payment->save();

            /*
            =====================================================
            6️⃣ Final Validation
            =====================================================
            */

            return response()->json([
                'status'          => abs($detectedAmount - $expectedAmount) <= 0.5,
                'expected_amount' => $expectedAmount,
                'detected_amount' => $detectedAmount,
                'raw_text'        => $text
            ]);

        } catch (\Exception $e) {
            return ['status'=>false,'message'=>$e->getMessage()];
        }
    }

    // public function checkReceiptMaster(PaymentMaster $payment)
    // {
    //     $expectedAmount = number_format((float)$payment->montant_paye, 2, '.', '');

    //     $imagePath = public_path($payment->document);

    //     if (!file_exists($imagePath)) {
    //         return [
    //             'success' => false,
    //             'message' => 'Document introuvable.'
    //         ];
    //     }

    //     try {

    //         // Convert image to base64
    //         $imageBase64 = base64_encode(file_get_contents($imagePath));

    //         // Call OpenAI Vision
    //         $client = OpenAI::client(env('OPENAI_API_KEY'));

    //         $response = $client->chat()->create([
    //             'model' => 'gpt-4o-mini',
    //             'messages' => [
    //                 [
    //                     'role' => 'user',
    //                     'content' => [
    //                         [
    //                             'type' => 'text',
    //                             'text' => "Extract ONLY the total payment amount from this receipt.
    //                                     Return ONLY JSON like:
    //                                     {\"amount\":\"123.45\"}"
    //                         ],
    //                         [
    //                             'type' => 'image_url',
    //                             'image_url' => [
    //                                 'url' => 'data:image/jpeg;base64,' . $imageBase64
    //                             ]
    //                         ]
    //                     ]
    //                 ]
    //             ]
    //         ]);

    //         $aiText = $response->choices[0]->message->content ?? null;

    //         $detectedAmount = null;

    //         if ($aiText) {
    //             $json = json_decode($aiText, true);
    //             $detectedAmount = $json['amount'] ?? null;
    //         }

    //         // Normalize comparison
    //         $isValid = false;

    //         if ($detectedAmount !== null) {
    //             $isValid = abs((float)$detectedAmount - (float)$expectedAmount) < 0.01;
    //         }

    //         // Save result (optional but recommended)
    //         $payment->ai_detected_amount = $detectedAmount;
    //         $payment->ai_validation_status = $isValid ? 'valid' : 'invalid';
    //         $payment->save();

    //         return [
    //             'success' => true,
    //             'validated' => $isValid,
    //             'detected_amount' => $detectedAmount,
    //             'expected_amount' => $expectedAmount,
    //             'status_label' => $isValid ?
    //                 '<span class="badge badge-success">Validé IA</span>' :
    //                 '<span class="badge badge-danger">Montant incorrect</span>'
    //         ];

    //     } catch (\Exception $e) {

    //         return [
    //             'success' => false,
    //             'message' => 'Erreur IA: ' . $e->getMessage()
    //         ];
    //     }
    // }

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
