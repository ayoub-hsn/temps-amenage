<?php

namespace App\Http\Controllers\adminEtab;

use App\Models\User;
use App\Models\Filiere;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StudentPasserelle;
use Asikam\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class CandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexMaster(Request $request)
    {
        $etablissement = auth()->user()->etablissement;

        if ($request->ajax()) {
            $query = StudentMaster::where('etablissement_id',$etablissement->id);

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

            $query->orderBy('id', 'desc');

            // Paginate the query based on the requested page
            $perPage = $request->input('length', 10); // Number of items per page
            $page = $request->input('start', 0) / $perPage + 1; // Current page number
            $data = $query->paginate($perPage, ['*'], 'page', $page);

            // Transform the data to include actions and related model attributes
            $transformedData = $data->map(function ($etudiant){
                // Determine the badge class based on 'verif' status
                $badgeClass = match ($etudiant->verif) {
                    'EN COURS'   => 'badge bg-warning text-white',
                    'REJETER'    => 'badge bg-danger text-white',
                    'VERIFIER'   => 'badge bg-success text-white',
                    default      => 'badge bg-secondary',
                };

                $confirmationBadge = $etudiant->confirmation_student == 1
                    ? '<span class="badge bg-success text-white">Oui</span>'
                    : '<span class="badge bg-danger text-white">Non</span>';

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
                    'actions' =>
                        '<a href="'.route('admin-etab.master.candidat.show', ['candidat' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>' .
                        '<a href="'.route('admin-etab.master.candidat.edit', ['candidat' => $etudiant->id]).'" class="btn btn-warning btn-sm">Modifier</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('admin-etab.etudiant.indexMasterCandidat',compact('etablissement'));
    }

    public function indexPasserelle(Request $request)
    {
        $etablissement = auth()->user()->etablissement;

        if ($request->ajax()) {
            $query = StudentPasserelle::where('etablissement_id',$etablissement->id);

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

            $query->orderBy('id', 'desc');

            // Paginate the query based on the requested page
            $perPage = $request->input('length', 10); // Number of items per page
            $page = $request->input('start', 0) / $perPage + 1; // Current page number
            $data = $query->paginate($perPage, ['*'], 'page', $page);

            // Transform the data to include actions and related model attributes
            $transformedData = $data->map(function ($etudiant){
                // Determine the badge class based on 'verif' status
                $badgeClass = match ($etudiant->verif) {
                    'EN COURS'   => 'badge bg-warning text-white',
                    'REJETER'    => 'badge bg-danger text-white',
                    'VERIFIER'   => 'badge bg-success text-white',
                    default      => 'badge bg-secondary',
                };

                $confirmationBadge = $etudiant->confirmation_student == 1
                    ? '<span class="badge bg-success text-white">Oui</span>'
                    : '<span class="badge bg-danger text-white">Non</span>';

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
                    'actions' =>
                        '<a href="'.route('admin-etab.passerelle.candidat.show', ['candidat' => $etudiant->id]).'" class="btn btn-info btn-sm mr-1">Afficher</a>' .
                        '<a href="'.route('admin-etab.passerelle.candidat.edit', ['candidat' => $etudiant->id]).'" class="btn btn-warning btn-sm">Modifier</a>',
                ];
            });

            return response()->json([
                'draw' => $request->input('draw'),
                'recordsTotal' => $data->total(),
                'recordsFiltered' => $data->total(),
                'data' => $transformedData,
            ]);
        }

        return view('admin-etab.etudiant.indexPasserelleCandidat',compact('etablissement'));
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
    public function showMasterCandidat($candidat)
    {
        $etablissement = auth()->user()->etablissement;
        $multipleChoixFiliereMaster = $etablissement && $etablissement->multiple_choix_filiere_master == 1;

        $etudiant = DB::table('student_masters')
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
            ->where('student_masters.id', $candidat)
            ->first();

            if(!$etudiant || $etudiant->etablissement_id != auth()->user()->etablissement->id){
                abort(403);
            }

            return view('admin-etab.etudiant.detailEtudiantMaster',compact('multipleChoixFiliereMaster','etudiant','etablissement'));
    }

    public function showPasserelleCandidat($candidat)
    {
        $etablissement = auth()->user()->etablissement;
        $multiple_choix_filiere_passerelle = $etablissement && $etablissement->multiple_choix_filiere_passerelle == 1;

        $etudiant = DB::table('student_passerelles')
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
            ->where('student_passerelles.id', $candidat)
            ->first();

            if(!$etudiant || $etudiant->etablissement_id != auth()->user()->etablissement->id){
                abort(403);
            }

            return view('admin-etab.etudiant.detailEtudiantLicenceExcellence',compact('multiple_choix_filiere_passerelle','etudiant','etablissement'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function editMasterCandidat($candidat)
    {
        $studentMaster =  StudentMaster::whereId($candidat)->first();
        if(!$studentMaster || $studentMaster->etablissement_id != auth()->user()->etablissement->id){
            abort(403);
        }
        $user = User::whereId($studentMaster->user_id)->first();

        return view('admin-etab.etudiant.editMasterCandidat',compact('user'));
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

    public function annulerConfirmationMasterCandidat($candidat){
        $studentMaster = StudentMaster::whereId($candidat)->first();
        if($studentMaster->confirmation_student == 0){
            return response()->json([
                'status' => 0,
                'message' => "Ce candidat n'a pas encore procédé à la confirmation de sa candidature"
            ]);
        }else{
            $studentMaster->update([
                'confirmation_student' => 0
            ]);

            return response()->json([
                'status' => 1,
                'message' => "Annulation de la confirmation de la candidature effectuée avec succès"
            ]);
        }
    }

    public function telechargrRecuMasterCandidat($candidat){
        $etudiant = StudentMaster::findOrFail($candidat);
        $etablissement = Etablissement::findOrFail($etudiant->etablissement_id);
        $filieres = Filiere::where('type',1)->get();

        // Short and clean ID
        $hashedId = Hashids::encode($etudiant->id);

        // URL with short hash
        $url = url("/candidatures/{$hashedId}/master/telecharger/visiteur");

        $qrContent = "Établissement: {$etablissement->nom}\nNom: {$etudiant->nom}\nPrénom: {$etudiant->prenom}\nLien: {$url}";

        $qrCode = QrCode::size(200)->generate($qrContent);

        $data = [
            'etudiant' => $etudiant,
            'registrationDate' => now()->format('d/m/Y'),
            'qrCode' => base64_encode($qrCode),
            'etablissement' => $etablissement,
            'filieres'  => $filieres,
        ];

        $pdf = Pdf::loadView('etudiant.PDF.recuMaster', $data);

        //return $pdf->stream('reçu_master_' . $etudiant->CNE . '.pdf');
        return $pdf->download('reçu_master_' . $etudiant->CNE . '.pdf');
    }

    public function editPasserelleCandidat($candidat)
    {
        $studentPasserelle =  StudentPasserelle::whereId($candidat)->first();
        if(!$studentPasserelle || $studentPasserelle->etablissement_id != auth()->user()->etablissement->id){
            abort(403);
        }
        $user = User::whereId($studentPasserelle->user_id)->first();

        return view('admin-etab.etudiant.editPasserelleCandidat',compact('user'));
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

    public function annulerConfirmationPasserelleCandidat($candidat){
        $studentPasserelle = StudentPasserelle::whereId($candidat)->first();
        if($studentPasserelle->confirmation_student == 0){
            return response()->json([
                'status' => 0,
                'message' => "Ce candidat n'a pas encore procédé à la confirmation de sa candidature"
            ]);
        }else{
            $studentPasserelle->update([
                'confirmation_student' => 0
            ]);

            return response()->json([
                'status' => 1,
                'message' => "Annulation de la confirmation de la candidature effectuée avec succès"
            ]);
        }
    }

    public function telechargrRecuPasserelleCandidat($candidat){
        $etudiant = StudentPasserelle::findOrFail($candidat);
        $etablissement = Etablissement::findOrFail($etudiant->etablissement_id);
        $filieres = Filiere::where('type',2)->get();

        // Short and clean ID
        $hashedId = Hashids::encode($etudiant->id);

        // URL with short hash
        $url = url("/candidatures/{$hashedId}/passerelle/telecharger/visiteur");

        $qrContent = "Établissement: {$etablissement->nom}\nNom: {$etudiant->nom}\nPrénom: {$etudiant->prenom}\nLien: {$url}";

        $qrCode = QrCode::size(200)->generate($qrContent);

        $data = [
            'etudiant' => $etudiant,
            'registrationDate' => now()->format('d/m/Y'),
            'qrCode' => base64_encode($qrCode),
            'etablissement' => $etablissement,
            'filieres'  => $filieres,
        ];

        $pdf = Pdf::loadView('etudiant.PDF.recuPasserelle', $data);

        //return $pdf->stream('reçu_licence_' . $etudiant->CNE . '.pdf');
        return $pdf->download('reçu_licence_' . $etudiant->CNE . '.pdf');
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
