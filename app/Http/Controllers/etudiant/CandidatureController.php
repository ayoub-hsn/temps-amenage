<?php

namespace App\Http\Controllers\etudiant;

use App\Models\User;
use App\Models\Filiere;
use App\Models\Bachelier;
use Illuminate\Http\Request;
use App\Models\Etablissement;
use App\Models\StudentMaster;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\StudentPasserelle;
use Asikam\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CandidatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filieres = Filiere::all();

        $candidaturesMaster = DB::table('student_masters')
        ->join('filieres', function ($join) {
            $join->on('student_masters.filiere', '=', 'filieres.id')
                ->orOn('student_masters.filiere_choix_1', '=', 'filieres.id')
                ->orOn('student_masters.filiere_choix_2', '=', 'filieres.id')
                ->orOn('student_masters.filiere_choix_3', '=', 'filieres.id');
        })
        ->join('etablissements', 'filieres.etablissement_id', '=', 'etablissements.id')
        ->where('student_masters.user_id', Auth::id())
        ->select(
            'filieres.id as filiere_id',
            'filieres.nom_complet as filiere_nom',
            'filieres.nom_abrv as filiere_abrev',
            'filieres.type',
            'etablissements.nom_abrev as etablissement_nom_abrev',
            'etablissements.nom as etablissement_nom',
            'etablissements.logo as etablissement_logo',
            'etablissements.multiple_choix_filiere_master as multiple_choix_filiere_master',
            'student_masters.confirmation_student',
            'student_masters.filiere as filiere',
            'student_masters.filiere_choix_1',
            'student_masters.filiere_choix_2',
            'student_masters.filiere_choix_3',
            'student_masters.id as candidature_id',
            'student_masters.verif as verif',
            'student_masters.created_at as date_candidature'
        )
        ->get();


        $candidaturesPasserelle = DB::table('student_passerelles')
        ->join('filieres', function ($join) {
            $join->on('student_passerelles.filiere', '=', 'filieres.id')
                ->orOn('student_passerelles.filiere_choix_1', '=', 'filieres.id')
                ->orOn('student_passerelles.filiere_choix_2', '=', 'filieres.id')
                ->orOn('student_passerelles.filiere_choix_3', '=', 'filieres.id');
        })
        ->join('etablissements', 'filieres.etablissement_id', '=', 'etablissements.id')
        ->where('student_passerelles.user_id', Auth::id())
        ->select(
            'filieres.id as filiere_id',
            'filieres.nom_complet as filiere_nom',
            'filieres.nom_abrv as filiere_abrev',
            'filieres.type',
            'etablissements.nom_abrev as etablissement_nom_abrev',
            'etablissements.nom as etablissement_nom',
            'etablissements.logo as etablissement_logo',
            'etablissements.multiple_choix_filiere_passerelle as multiple_choix_filiere_passerelle',
            'student_passerelles.confirmation_student',
            'student_passerelles.filiere as filiere',
            'student_passerelles.filiere_choix_1',
            'student_passerelles.filiere_choix_2',
            'student_passerelles.filiere_choix_3',
            'student_passerelles.id as candidature_id',
            'student_passerelles.verif as verif',
            'student_passerelles.created_at as date_candidature'
        )
        ->get();

        $candidaturesBachelier = DB::table('bacheliers')
        ->join('filieres', function ($join) {
            $join->on('bacheliers.filiere', '=', 'filieres.id')
                ->orOn('bacheliers.filiere_choix_1', '=', 'filieres.id')
                ->orOn('bacheliers.filiere_choix_2', '=', 'filieres.id')
                ->orOn('bacheliers.filiere_choix_3', '=', 'filieres.id');
        })
        ->join('etablissements', 'filieres.etablissement_id', '=', 'etablissements.id')
        ->where('bacheliers.user_id', Auth::id())
        ->select(
            'filieres.id as filiere_id',
            'filieres.nom_complet as filiere_nom',
            'filieres.nom_abrv as filiere_abrev',
            'filieres.type',
            'etablissements.nom_abrev as etablissement_nom_abrev',
            'etablissements.nom as etablissement_nom',
            'etablissements.logo as etablissement_logo',
            'etablissements.multiple_choix_filiere_passerelle as multiple_choix_filiere_passerelle',
            'bacheliers.confirmation_student',
            'bacheliers.filiere as filiere',
            'bacheliers.filiere_choix_1',
            'bacheliers.filiere_choix_2',
            'bacheliers.filiere_choix_3',
            'bacheliers.id as candidature_id',
            'bacheliers.verif as verif',
            'bacheliers.created_at as date_candidature'
        )
        ->get();



        return view('etudiant.candidatures.index',compact('filieres','candidaturesMaster','candidaturesPasserelle','candidaturesBachelier'));
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

    public function showMaster($id){
        $etudiant = StudentMaster::whereId($id)->first();
        $etablissement = Etablissement::whereId($etudiant->etablissement_id)->first();
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
        ->where('student_masters.id', $id)  // Filter by the student ID
        ->first(); // Use `first()` to get a single record
        return view('etudiant.candidatures.showCandidatureMaster',compact('etudiant','etablissement'));
    }

     public function editMaster($id)
    {
        $etudiant = StudentMaster::whereId($id)->first();
        if($etudiant){
            if($etudiant->confirmation_student == 0){
                $etablissement = Etablissement::whereId($etudiant->etablissement_id)->first();
                $etablissement->load(['serie_bac']);
                $filieres = Filiere::where('etablissement_id',$etablissement->id)
                ->where('type',1)
                ->where('active',1)
                ->get();
                return view('etudiant.candidatures.editMaster',compact('etudiant','etablissement','filieres'));
            }else{
                return back()->with('warning',"Votre ne pouvez pas modifié votre candidature");
            }
        }else{
            return back()->with('error',"Votre candidature n'est pas trouvé");
        }
    }

    public function updateMasterIdentite(StudentMaster $etudiant,Request $request){
        // return $request->all();
        $request->validate([
                'nom' => 'nullable|min:2|max:50',
                'prenom' => 'nullable|min:2|max:50',
                // 'nomar' => ['nullable', 'min:2', 'max:50', 'regex:/^[\p{Arabic}\s]+$/u'],
                // 'prenomar' => ['nullable', 'min:2', 'max:50', 'regex:/^[\p{Arabic}\s]+$/u'],
                // 'datenais' => 'nullable',
                // 'sexe' => 'nullable',
                // 'payschamp' => 'nullable|min:2|max:70',
                // 'villenais' => 'nullable|min:2|max:70',
                // 'villechamp' => ['nullable', 'min:2', 'max:70', 'regex:/^[\p{Arabic}\s]+$/u'],
                // 'adresse' => 'nullable|min:10|max:250',
                'phone' => 'nullable|digits:10',

            ], [
                // Français pour les champs en français
                'nullable' => 'Le champ :attribute est obligatoire.',
                'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
                'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
                'digits' => 'Le champ :attribute doit contenir exactement :digits chiffres.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',

                // Messages personnalisés pour les champs en arabe
                'nomar.nullable' => 'الاسم العائلي باللغة العربية إجباري.',
                'nomar.min' => 'الاسم العائلي يجب أن يحتوي على حرفين على الأقل.',
                'nomar.max' => 'الاسم العائلي لا يجب أن يتجاوز 50 حرفًا.',
                'nomar.regex' => 'الاسم العائلي يجب أن يكون باللغة العربية فقط.',

                'prenomar.nullable' => 'الاسم الشخصي باللغة العربية إجباري.',
                'prenomar.min' => 'الاسم الشخصي يجب أن يحتوي على حرفين على الأقل.',
                'prenomar.max' => 'الاسم الشخصي لا يجب أن يتجاوز 50 حرفًا.',
                'prenomar.regex' => 'الاسم الشخصي يجب أن يكون باللغة العربية فقط.',

                'villechamp.nullable' => 'مدينة الازدياد بالعربية إجبارية.',
                'villechamp.min' => 'مدينة الازدياد يجب أن تحتوي على حرفين على الأقل.',
                'villechamp.max' => 'مدينة الازدياد لا يجب أن تتجاوز 70 حرفًا.',
                'villechamp.regex' => 'مدينة الازدياد يجب أن تكون باللغة العربية فقط.',
            ], [
                // Aliases français
                'nom' => 'Nom',
                'prenom' => 'Prénom',
                'datenais' => 'Date de naissance',
                'sexe' => 'Sexe',
                'payschamp' => 'Pays',
                'villenais' => 'Ville de naissance (Fr)',
                'adresse' => 'Adresse',
                'phone' => 'Téléphone',
        ]);

        $user = User::whereId(Auth::id())->first();
        $user->update([
            'telephone' => $request->phone
        ]);
        $etudiant->update($request->except(['CNE','CIN']));

        return back()->with('message','Vos informations sont modifié avec succées');
    }

    public function updateMasterAcademique(StudentMaster $etudiant,Request $request){
        $request->validate([
            'serie' => 'nullable',
            'typelicence' => 'nullable|max:200',
            'mentionlp' => 'nullable',
            'specialitelp' => 'nullable|min:2|max:200',
            'etblsmtLp' => 'nullable|min:2|max:200',
            'date_obtention_LP' => 'nullable',
            'moyenne_licence' => 'nullable',
            'secteur' => 'nullable|max:200',
            'poste' => 'nullable|max:200',
        ]);

        $etudiant->update($request->all());
        return back()->with('message','Vos informations sont modifié avec succées');
    }

    public function updateMasterDocument(StudentMaster $etudiant,Request $request){
       // return $data = $request->all();

        $request->validate([
            'path_photo' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_cin'   => 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_bac'   => 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_licence'=> 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_attestation_non_emploi' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_cv'    => 'nullable|file|mimes:pdf|max:350'
        ]);

        $data = $request->all();
        $cin = $etudiant->CIN;

        if ($request->hasFile('path_photo')) {
            $data['path_photo'] = $this->saveFileMaster($request->file('path_photo'), $cin.'-PHOTO.jpg');
        }

        if ($request->hasFile('path_cin')) {
            $data['path_cin'] = $this->saveFileMaster($request->file('path_cin'), $cin.'-CIN.jpg');
        }

        if ($request->hasFile('path_bac')) {
            $data['path_bac'] = $this->saveFileMaster($request->file('path_bac'), $cin.'-BAC.jpg');
        }

        if ($request->hasFile('path_licence')) {
            $data['path_licence'] = $this->saveFileMaster($request->file('path_licence'), $cin.'-LICENCE.jpg');
        }

        if ($request->hasFile('path_attestation_non_emploi')) {
            $data['path_attestation_non_emploi'] = $this->saveFileMaster($request->file('path_attestation_non_emploi'), $cin.'-ATTESTATIONNONEMPLOI.jpg');
        }

        if ($request->hasFile('path_cv')) {
            $data['path_cv'] = $this->saveFileMaster($request->file('path_cv'), $cin.'-CV.pdf');
        }



        $etudiant->update($data);

        return back()->with('message','Vos documents sont modifié avec succées');
    }

    private function saveFileMaster($file, $filename)
    {
        $destinationPath = public_path('uploads/master');
        $file->move($destinationPath, $filename);

        return 'uploads/master/' . $filename;
    }

    public function updateChoixFiliereMaster(StudentMaster $etudiant,Request $request){
        $etablissement = Etablissement::whereId($etudiant->etablissement_id)->first();
        if($etablissement->multiple_choix_filiere_master){
            if(!$request->filiere_choix_1 || !$request->filiere_choix_2 || !$request->filiere_choix_3){
                return back()->with('warning','Veuillez Choisir 3 Choix');
            }
            $etudiant->filiere_choix_1 = $request->filiere_choix_1;
            $etudiant->filiere_choix_2 = $request->filiere_choix_2;
            $etudiant->filiere_choix_3 = $request->filiere_choix_3;
        }else{
            $etudiant->filiere = $request->filieres[0];
        }

        $etudiant->save();

        return back()->with('message','Votre choix de Filieres est modifié avec succées');
    }


    public function confirmerMaster($id){
        $etudiant = StudentMaster::whereId($id)->first();
        $etudiant->update([
            'confirmation_student' => 1
        ]);
        return back()->with('message','Vous avez confirmé avec succées');
    }

    public function telechargerMaster($id)
    {
        $etudiant = StudentMaster::findOrFail($id);
        $etablissement = Etablissement::findOrFail($etudiant->etablissement_id);
        $filieres = Filiere::where('type',1)->get();

        // Short and clean ID
        $hashedId = Hashids::encode($etudiant->id);

        // URL with short hash
        $url = url("/candidatures/{$hashedId}/master/telecharger/visiteur");

        $qrContent = "Établissement: {$etablissement->nom} - Master - Formation Initiale en Temps Aménagé\n"
        . "Nom: {$etudiant->nom}\n"
        . "Prénom: {$etudiant->prenom}\n"
        . "Lien: {$url}";
        $qrCode = QrCode::size(200)->generate($qrContent);

        $photoPath = public_path($etudiant->path_photo);

        if ($etudiant->path_photo && file_exists($photoPath)) {
            // Fix the corrupted JPEG
            $image = @imagecreatefromjpeg($photoPath);
            if ($image !== false) {
                imagejpeg($image, $photoPath, 100);
                imagedestroy($image);
            }
        }

        $data = [
            'etudiant' => $etudiant,
            'registrationDate' => now()->format('d/m/Y'),
            'qrCode' => base64_encode($qrCode),
            'etablissement' => $etablissement,
            'filieres'  => $filieres,
        ];

        $pdf = Pdf::loadView('etudiant.PDF.recuMaster', $data);

        // return $pdf->stream('reçu_master_' . $etudiant->CNE . '.pdf');
        return $pdf->download('reçu_master_' . $etudiant->CNE . '.pdf');
    }



    public function telechargerMasterVisiteur($id)
    {
        // 🔓 Decode the hashed ID
        $decoded = Hashids::decode($id);

        if (empty($decoded)) {
            abort(404, 'ID invalide');
        }

        $realId = $decoded[0];

        // 📦 Retrieve the student and establishment data
        // Short and clean ID
        $hashedId = Hashids::encode($realId);
        $etudiant = StudentMaster::findOrFail($realId);
        $etablissement = Etablissement::findOrFail($etudiant->etablissement_id);
        $filieres = Filiere::where('type',1)->get();

        $url = url("/candidatures/{$hashedId}/master/telecharger/visiteur");

        // 📄 Compose QR content (no need to regenerate here if not needed)
        $qrContent = "Établissement: {$etablissement->nom} - Master - Formation Initiale en Temps Aménagé\n"
        . "Nom: {$etudiant->nom}\n"
        . "Prénom: {$etudiant->prenom}\n"
        . "Lien: {$url}";
        $qrCode = QrCode::size(200)->generate($qrContent);

        $photoPath = public_path($etudiant->path_photo);

        if ($etudiant->path_photo && file_exists($photoPath)) {
            // Fix the corrupted JPEG
            $image = @imagecreatefromjpeg($photoPath);
            if ($image !== false) {
                imagejpeg($image, $photoPath, 100);
                imagedestroy($image);
            }
        }

        $data = [
            'etudiant' => $etudiant,
            'registrationDate' => now()->format('d/m/Y'),
            'qrCode' => base64_encode($qrCode),
            'etablissement' => $etablissement,
            'filieres'  => $filieres,
        ];

        // 📄 Generate the PDF using the same view
        $pdf = Pdf::loadView('etudiant.PDF.recuMaster', $data);

        // 📤 Stream the generated PDF
        return $pdf->stream('reçu_master_' . $etudiant->CNE . '.pdf');
    }



    public function showPasserelle($id){
        $etudiant = StudentPasserelle::whereId($id)->first();
        $etablissement = Etablissement::whereId($etudiant->etablissement_id)->first();
        $multipleChoixFiliereMaster = $etablissement->multiple_choix_filiere_master == 1;

        $etudiant = DB::table('student_passerelles')
        ->select('student_passerelles.*',
            // Separate columns for each filiere choice if multiple choices are allowed
            DB::raw($multipleChoixFiliereMaster ?
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
        ->where('student_passerelles.id', $id)  // Filter by the student ID
        ->first(); // Use `first()` to get a single record
        return view('etudiant.candidatures.showCanadidaturePasserelle',compact('etudiant','etablissement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
   

    

    


    public function editPasserelle($id){
        $etudiant = StudentPasserelle::whereId($id)->first();
        if($etudiant){
            if($etudiant->confirmation_student == 0){
                $etablissement = Etablissement::whereId($etudiant->etablissement_id)->first();
                $etablissement->load(['serie_bac','diplomebacplus2']);
                $filieres = Filiere::where('etablissement_id',$etablissement->id)
                ->where('type',2)
                ->where('active',1)
                ->get();
                return view('etudiant.candidatures.editPasserelle',compact('etudiant','etablissement','filieres'));
            }else{
                return back()->with('warning',"Votre ne pouvez pas modifié votre candidature");
            }
        }else{
            return back()->with('error',"Votre candidature n'est pas trouvé");
        }
    }

    public function updatePasserelleIdentite(StudentPasserelle $etudiant,Request $request){
        // return $request->all();
        $request->validate([
                'nom' => 'nullable|min:2|max:50',
                'prenom' => 'nullable|min:2|max:50',
                // 'nomar' => ['nullable', 'min:2', 'max:50', 'regex:/^[\p{Arabic}\s]+$/u'],
                // 'prenomar' => ['nullable', 'min:2', 'max:50', 'regex:/^[\p{Arabic}\s]+$/u'],
                // 'datenais' => 'nullable',
                // 'sexe' => 'nullable',
                // 'payschamp' => 'nullable|min:2|max:70',
                // 'villenais' => 'nullable|min:2|max:70',
                // 'villechamp' => ['nullable', 'min:2', 'max:70', 'regex:/^[\p{Arabic}\s]+$/u'],
                // 'adresse' => 'nullable|min:10|max:250',
                'phone' => 'nullable|digits:10',
            ], [
                // Français pour les champs en français
                'nullable' => 'Le champ :attribute est obligatoire.',
                'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
                'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
                'digits' => 'Le champ :attribute doit contenir exactement :digits chiffres.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',

                // Messages personnalisés pour les champs en arabe
                'nomar.nullable' => 'الاسم العائلي باللغة العربية إجباري.',
                'nomar.min' => 'الاسم العائلي يجب أن يحتوي على حرفين على الأقل.',
                'nomar.max' => 'الاسم العائلي لا يجب أن يتجاوز 50 حرفًا.',
                'nomar.regex' => 'الاسم العائلي يجب أن يكون باللغة العربية فقط.',

                'prenomar.nullable' => 'الاسم الشخصي باللغة العربية إجباري.',
                'prenomar.min' => 'الاسم الشخصي يجب أن يحتوي على حرفين على الأقل.',
                'prenomar.max' => 'الاسم الشخصي لا يجب أن يتجاوز 50 حرفًا.',
                'prenomar.regex' => 'الاسم الشخصي يجب أن يكون باللغة العربية فقط.',

                'villechamp.nullable' => 'مدينة الازدياد بالعربية إجبارية.',
                'villechamp.min' => 'مدينة الازدياد يجب أن تحتوي على حرفين على الأقل.',
                'villechamp.max' => 'مدينة الازدياد لا يجب أن تتجاوز 70 حرفًا.',
                'villechamp.regex' => 'مدينة الازدياد يجب أن تكون باللغة العربية فقط.',
            ], [
                // Aliases français
                'nom' => 'Nom',
                'prenom' => 'Prénom',
                'datenais' => 'Date de naissance',
                'sexe' => 'Sexe',
                'payschamp' => 'Pays',
                'villenais' => 'Ville de naissance (Fr)',
                'adresse' => 'Adresse',
                'phone' => 'Téléphone',
        ]);


        $user = User::whereId(Auth::id())->first();
        $user->update([
            'telephone' => $request->phone
        ]);
        $etudiant->update($request->except(['CNE','CIN']));

        return back()->with('message','Vos informations sont modifié avec succées');
    }

    public function updatePasserelleAcademique(StudentPasserelle $etudiant,Request $request){
        $request->validate([
            'serie' => 'nullable',

            'diplomedeug' => 'nullable',
            'mentiondeug' => 'nullable',
            'specialitedeug' => 'nullable|min:2|max:200',
            'etblsmtdeug' => 'nullable|min:2|max:200',
            'date_obtention_deug' => 'nullable',
            'moyenne_deug' => 'nullable',
            'secteur' => 'nullable|max:200',
            'poste' => 'nullable|max:200',
            // 'lieutravail' => 'nullable|max:200',
            // 'villetravail' => 'nullable|max:200',
        ]);

        $etudiant->update($request->all());
        return back()->with('message','Vos informations sont modifié avec succées');
    }

    public function updatePasserelleDocument(StudentPasserelle $etudiant,Request $request){
       // return $data = $request->all();

        $request->validate([
            'path_photo' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_cin'   => 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_bac'   => 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_diplomedeug' => 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_attestation_non_emploi'   => 'nullable|file|mimes:jpeg,jpg,png|max:300',
            'path_cv'    => 'nullable|file|mimes:pdf|max:350'
        ]);

        $data = $request->all();
        $cin = $etudiant->CIN;
        if ($request->hasFile('path_photo')) {
            $data['path_photo'] = $this->saveFilePasserelle($request->file('path_photo'), $cin.'-PHOTO.jpg');
        }

        if ($request->hasFile('path_cin')) {
            $data['path_cin'] = $this->saveFilePasserelle($request->file('path_cin'), $cin.'-CIN.jpg');
        }

        if ($request->hasFile('path_bac')) {
            $data['path_bac'] = $this->saveFilePasserelle($request->file('path_bac'), $cin.'-BAC.jpg');
        }

        if ($request->hasFile('path_diplomedeug')) {
            $data['path_diplomedeug'] = $this->saveFilePasserelle($request->file('path_diplomedeug'), $cin.'-DEUG.jpg');
        }

        if ($request->hasFile('path_attestation_non_emploi')) {
            $data['path_attestation_non_emploi'] = $this->saveFilePasserelle($request->file('path_attestation_non_emploi'), $cin.'-ATTESTATIONNONEMPLOI.jpg');
        }

        if ($request->hasFile('path_cv')) {
            $data['path_cv'] = $this->saveFilePasserelle($request->file('path_cv'), $cin.'-CV.pdf');
        }



        $etudiant->update($data);

        return back()->with('message','Vos documents sont modifié avec succées');
    }

    private function saveFilePasserelle($file, $filename){
        $destinationPath = public_path('uploads/passerelle');
        $file->move($destinationPath, $filename);

        return 'uploads/passerelle/' . $filename;
    }

    public function updateChoixFilierePasserelle(StudentPasserelle $etudiant,Request $request){
        $etablissement = Etablissement::whereId($etudiant->etablissement_id)->first();
        if($etablissement->multiple_choix_filiere_passerelle){
            if(!$request->filiere_choix_1 || !$request->filiere_choix_2 || !$request->filiere_choix_3){
                return back()->with('warning','Veuillez Choisir 3 Choix');
            }
            $etudiant->filiere_choix_1 = $request->filiere_choix_1;
            $etudiant->filiere_choix_2 = $request->filiere_choix_2;
            $etudiant->filiere_choix_3 = $request->filiere_choix_3;
        }else{
            $etudiant->filiere = $request->filieres[0];
        }

        $etudiant->save();

        return back()->with('message','Votre choix de Filieres est modifié avec succées');
    }

    public function confirmerPasserelle($id){
        $etudiant = StudentPasserelle::whereId($id)->first();
        $etudiant->update([
            'confirmation_student' => 1
        ]);
        return back()->with('message','Vous avez confirmé avec succées');
    }

    public function telechargerPasserelle($id)
    {
        $etudiant = StudentPasserelle::findOrFail($id);
        $etablissement = Etablissement::findOrFail($etudiant->etablissement_id);
        $filieres = Filiere::where('type',2)->get();

        // Short and clean ID
        $hashedId = Hashids::encode($etudiant->id);

        // URL with short hash
        $url = url("/candidatures/{$hashedId}/passerelle/telecharger/visiteur");

        $qrContent = "Établissement: {$etablissement->nom} - Licences (Accès S5) - Formation Initiale en Temps Aménagé\n"
        . "Nom: {$etudiant->nom}\n"
        . "Prénom: {$etudiant->prenom}\n"
        . "Lien: {$url}";
        $qrCode = QrCode::size(200)->generate($qrContent);

        $photoPath = public_path($etudiant->path_photo);

        if ($etudiant->path_photo && file_exists($photoPath)) {
            // Fix the corrupted JPEG
            $image = @imagecreatefromjpeg($photoPath);
            if ($image !== false) {
                imagejpeg($image, $photoPath, 100);
                imagedestroy($image);
            }
        }

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



    public function telechargerPasserelleVisiteur($id)
    {
        // 🔓 Decode the hashed ID
        $decoded = Hashids::decode($id);

        if (empty($decoded)) {
            abort(404, 'ID invalide');
        }

        $realId = $decoded[0];

        // 📦 Retrieve the student and establishment data
        // Short and clean ID
        $hashedId = Hashids::encode($realId);
        $etudiant = StudentPasserelle::findOrFail($realId);
        $etablissement = Etablissement::findOrFail($etudiant->etablissement_id);
        $filieres = Filiere::where('type',2)->get();

        $url = url("/candidatures/{$hashedId}/passerelle/telecharger/visiteur");

        // 📄 Compose QR content (no need to regenerate here if not needed)
        $qrContent = "Établissement: {$etablissement->nom} - Licences (Accès S5) - Formation Initiale en Temps Aménagé\n"
        . "Nom: {$etudiant->nom}\n"
        . "Prénom: {$etudiant->prenom}\n"
        . "Lien: {$url}";

        $qrCode = QrCode::size(200)->generate($qrContent);


        $photoPath = public_path($etudiant->path_photo);

        if ($etudiant->path_photo && file_exists($photoPath)) {
            // Fix the corrupted JPEG
            $image = @imagecreatefromjpeg($photoPath);
            if ($image !== false) {
                imagejpeg($image, $photoPath, 100);
                imagedestroy($image);
            }
        }

        $data = [
            'etudiant' => $etudiant,
            'registrationDate' => now()->format('d/m/Y'),
            'qrCode' => base64_encode($qrCode),
            'etablissement' => $etablissement,
            'filieres'  => $filieres,
        ];

        // 📄 Generate the PDF using the same view
        $pdf = Pdf::loadView('etudiant.PDF.recuPasserelle', $data);

        // 📤 Stream the generated PDF
        return $pdf->stream('reçu_licence_' . $etudiant->CNE . '.pdf');
    }



    public function showBachelier($id){
        $etudiant = Bachelier::whereId($id)->first();
        $etablissement = Etablissement::whereId($etudiant->etablissement_id)->first();
        $multipleChoixFiliereMaster = $etablissement->multiple_choix_filiere_master == 1;

        $etudiant = DB::table('bacheliers')
        ->select('bacheliers.*',
            // Separate columns for each filiere choice if multiple choices are allowed
            DB::raw($multipleChoixFiliereMaster ?
                "filiere1.nom_complet AS filiere_choix_1_name,
                filiere2.nom_complet AS filiere_choix_2_name,
                filiere3.nom_complet AS filiere_choix_3_name"
                :
                "filiere.nom_complet AS filiere_name" // Only one column for the single filiere
            )
        )
        ->leftJoin('filieres AS filiere1', 'bacheliers.filiere_choix_1', '=', 'filiere1.id')
        ->leftJoin('filieres AS filiere2', 'bacheliers.filiere_choix_2', '=', 'filiere2.id')
        ->leftJoin('filieres AS filiere3', 'bacheliers.filiere_choix_3', '=', 'filiere3.id')
        ->leftJoin('filieres AS filiere', function ($join) {
            $join->on('bacheliers.filiere', '=', 'filiere.id');
        })
        ->where('bacheliers.id', $id)  // Filter by the student ID
        ->first(); // Use `first()` to get a single record
        return view('etudiant.candidatures.showCandidatureBachelier',compact('etudiant','etablissement'));
    }


    public function editBachelier($id){
        $etudiant = Bachelier::whereId($id)->first();
        if($etudiant){
            if($etudiant->confirmation_student == 0){
                $etablissement = Etablissement::whereId($etudiant->etablissement_id)->first();
                $etablissement->load(['serie_bac']);
                $filieres = Filiere::where('etablissement_id',$etablissement->id)
                ->where('type',3)
                ->where('active',1)
                ->get();
                return view('etudiant.candidatures.editBachelier',compact('etudiant','etablissement','filieres'));
            }else{
                return back()->with('warning',"Votre ne pouvez pas modifié votre candidature");
            }
        }else{
            return back()->with('error',"Votre candidature n'est pas trouvé");
        }
    }

    public function updateBachelierIdentite(Bachelier $etudiant,Request $request){
        // return $request->all();
        $request->validate([
                'nom' => 'nullable|min:2|max:50',
                'prenom' => 'nullable|min:2|max:50',
                // 'nomar' => ['nullable', 'min:2', 'max:50', 'regex:/^[\p{Arabic}\s]+$/u'],
                // 'prenomar' => ['nullable', 'min:2', 'max:50', 'regex:/^[\p{Arabic}\s]+$/u'],
                // 'datenais' => 'nullable',
                // 'sexe' => 'nullable',
                // 'payschamp' => 'nullable|min:2|max:70',
                // 'villenais' => 'nullable|min:2|max:70',
                // 'villechamp' => ['nullable', 'min:2', 'max:70', 'regex:/^[\p{Arabic}\s]+$/u'],
                // 'adresse' => 'nullable|min:10|max:250',
                'phone' => 'nullable|digits:10',
            ], [
                // Français pour les champs en français
                'nullable' => 'Le champ :attribute est obligatoire.',
                'min' => 'Le champ :attribute doit contenir au moins :min caractères.',
                'max' => 'Le champ :attribute ne peut pas dépasser :max caractères.',
                'digits' => 'Le champ :attribute doit contenir exactement :digits chiffres.',
                'email' => 'Le champ :attribute doit être une adresse email valide.',

                // Messages personnalisés pour les champs en arabe
                'nomar.nullable' => 'الاسم العائلي باللغة العربية إجباري.',
                'nomar.min' => 'الاسم العائلي يجب أن يحتوي على حرفين على الأقل.',
                'nomar.max' => 'الاسم العائلي لا يجب أن يتجاوز 50 حرفًا.',
                'nomar.regex' => 'الاسم العائلي يجب أن يكون باللغة العربية فقط.',

                'prenomar.nullable' => 'الاسم الشخصي باللغة العربية إجباري.',
                'prenomar.min' => 'الاسم الشخصي يجب أن يحتوي على حرفين على الأقل.',
                'prenomar.max' => 'الاسم الشخصي لا يجب أن يتجاوز 50 حرفًا.',
                'prenomar.regex' => 'الاسم الشخصي يجب أن يكون باللغة العربية فقط.',

                'villechamp.nullable' => 'مدينة الازدياد بالعربية إجبارية.',
                'villechamp.min' => 'مدينة الازدياد يجب أن تحتوي على حرفين على الأقل.',
                'villechamp.max' => 'مدينة الازدياد لا يجب أن تتجاوز 70 حرفًا.',
                'villechamp.regex' => 'مدينة الازدياد يجب أن تكون باللغة العربية فقط.',
            ], [
                // Aliases français
                'nom' => 'Nom',
                'prenom' => 'Prénom',
                'datenais' => 'Date de naissance',
                'sexe' => 'Sexe',
                'payschamp' => 'Pays',
                'villenais' => 'Ville de naissance (Fr)',
                'adresse' => 'Adresse',
                'phone' => 'Téléphone',
        ]);


        $user = User::whereId(Auth::id())->first();
        $user->update([
            'telephone' => $request->phone
        ]);
        $etudiant->update($request->except(['CNE','CIN']));

        return back()->with('message','Vos informations sont modifié avec succées');
    }

    public function updateBachelierAcademique(Bachelier $etudiant,Request $request){
        $request->validate([
            'serie' => 'nullable',
            'moyenne_bac' => 'nullable',

            'secteur' => 'nullable|max:200',
            'poste' => 'nullable|max:200',
            // 'lieutravail' => 'nullable|max:200',
            // 'villetravail' => 'nullable|max:200',
        ]);

        $etudiant->update($request->all());
        return back()->with('message','Vos informations sont modifié avec succées');
    }


    public function updateChoixFiliereBachelier(Bachelier $etudiant,Request $request){
        $etablissement = Etablissement::whereId($etudiant->etablissement_id)->first();
        if($etablissement->multiple_choix_filiere_passerelle){
            if(!$request->filiere_choix_1 || !$request->filiere_choix_2 || !$request->filiere_choix_3){
                return back()->with('warning','Veuillez Choisir 3 Choix');
            }
            $etudiant->filiere_choix_1 = $request->filiere_choix_1;
            $etudiant->filiere_choix_2 = $request->filiere_choix_2;
            $etudiant->filiere_choix_3 = $request->filiere_choix_3;
        }else{
            $etudiant->filiere = $request->filieres[0];
        }

        $etudiant->save();

        return back()->with('message','Votre choix de Filieres est modifié avec succées');
    }

    public function confirmerBachelier($id){
        $etudiant = Bachelier::whereId($id)->first();
        $etudiant->update([
            'confirmation_student' => 1
        ]);
        return back()->with('message','Vous avez confirmé avec succées');
    }

    public function telechargerBachelier($id)
    {
        $etudiant = Bachelier::findOrFail($id);
        $etablissement = Etablissement::findOrFail($etudiant->etablissement_id);
        $filieres = Filiere::where('type',3)->get();

        // Short and clean ID
        $hashedId = Hashids::encode($etudiant->id);

        // URL with short hash
        $url = url("/candidatures/{$hashedId}/bachelier/telecharger/visiteur");

        $qrContent = "Établissement: {$etablissement->nom} - Licences (Accès S1) - Formation Initiale en Temps Aménagé\n"
        . "Nom: {$etudiant->nom}\n"
        . "Prénom: {$etudiant->prenom}\n"
        . "Lien: {$url}";
        $qrCode = QrCode::size(200)->generate($qrContent);

        $photoPath = public_path($etudiant->path_photo);

        if ($etudiant->path_photo && file_exists($photoPath)) {
            // Fix the corrupted JPEG
            $image = @imagecreatefromjpeg($photoPath);
            if ($image !== false) {
                imagejpeg($image, $photoPath, 100);
                imagedestroy($image);
            }
        }

        $data = [
            'etudiant' => $etudiant,
            'registrationDate' => now()->format('d/m/Y'),
            'qrCode' => base64_encode($qrCode),
            'etablissement' => $etablissement,
            'filieres'  => $filieres,
        ];

        $pdf = Pdf::loadView('etudiant.PDF.recuBachelier', $data);

        //return $pdf->stream('reçu_licence_' . $etudiant->CNE . '.pdf');
        return $pdf->download('reçu_licence_S1_' . $etudiant->CNE . '.pdf');
    }

    public function telechargerBechelierVisiteur($id)
    {
        // 🔓 Decode the hashed ID
        $decoded = Hashids::decode($id);

        if (empty($decoded)) {
            abort(404, 'ID invalide');
        }

        $realId = $decoded[0];

        // 📦 Retrieve the student and establishment data
        // Short and clean ID
        $hashedId = Hashids::encode($realId);
        $etudiant = Bachelier::findOrFail($realId);
        $etablissement = Etablissement::findOrFail($etudiant->etablissement_id);
        $filieres = Filiere::where('type',3)->get();

        $url = url("/candidatures/{$hashedId}/bachelier/telecharger/visiteur");

        // 📄 Compose QR content (no need to regenerate here if not needed)
        $qrContent = "Établissement: {$etablissement->nom} - Licences (Accès S1) - Formation Initiale en Temps Aménagé\n"
        . "Nom: {$etudiant->nom}\n"
        . "Prénom: {$etudiant->prenom}\n"
        . "Lien: {$url}";

        $qrCode = QrCode::size(200)->generate($qrContent);


        $photoPath = public_path($etudiant->path_photo);

        if ($etudiant->path_photo && file_exists($photoPath)) {
            // Fix the corrupted JPEG
            $image = @imagecreatefromjpeg($photoPath);
            if ($image !== false) {
                imagejpeg($image, $photoPath, 100);
                imagedestroy($image);
            }
        }

        $data = [
            'etudiant' => $etudiant,
            'registrationDate' => now()->format('d/m/Y'),
            'qrCode' => base64_encode($qrCode),
            'etablissement' => $etablissement,
            'filieres'  => $filieres,
        ];

        // 📄 Generate the PDF using the same view
        $pdf = Pdf::loadView('etudiant.PDF.recuBachelier', $data);

        // 📤 Stream the generated PDF
        return $pdf->stream('reçu_licence_S1_' . $etudiant->CNE . '.pdf');
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
