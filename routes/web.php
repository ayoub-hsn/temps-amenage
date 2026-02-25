<?php

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\FormBacController;
use App\Http\Controllers\supAdmin\HomeController;
use App\Http\Controllers\supAdmin\UserController;
use App\Http\Controllers\adminEtab\FiliereController;
use App\Http\Controllers\adminEtab\PaymentController;
use App\Http\Controllers\supAdmin\SerieBacController;
use App\Http\Controllers\adminEtab\CandidatController;
use App\Http\Controllers\adminEtab\ProvinceController;
use App\Http\Controllers\supAdmin\ActualiteController;
use App\Http\Controllers\supAdmin\CalendrierController;
use App\Http\Controllers\adminFiliere\ProfileController;
use App\Http\Controllers\etudiant\CandidatureController;
use App\Http\Controllers\supAdmin\ResponsableController;
use App\Http\Controllers\adminEtab\NotificationController;
use App\Http\Controllers\supAdmin\EtablissementController;
use App\Http\Controllers\supAdmin\DiplomeBacPlusDeuxController;
use App\Http\Controllers\HomeController as ControllersHomeController;
use App\Http\Controllers\etudiant\HomeController as EtudiantHomeController;
use App\Http\Controllers\visiteur\HomeController as VisiteurHomeController;
use App\Http\Controllers\adminEtab\HomeController as AdminEtabHomeController;
use App\Http\Controllers\supAdmin\FiliereController as SupAdminFiliereController;
use App\Http\Controllers\supAdmin\ProfileController as SupAdminProfileController;
use App\Http\Controllers\visiteur\ProfileController as VisiteurProfileController;
use App\Http\Controllers\adminEtab\ProfileController as AdminEtabProfileController;
use App\Http\Controllers\adminFiliere\HomeController as AdminFiliereHomeController;
use App\Http\Controllers\supAdmin\ProvinceController as SupAdminProvinceController;
use App\Http\Controllers\adminEtab\ActualiteController as AdminEtabActualiteController;
use App\Http\Controllers\adminFiliere\FiliereController as AdminFiliereFiliereController;
use App\Http\Controllers\adminEtab\ResponsableController as AdminEtabResponsableController;
use App\Http\Controllers\adminEtab\EtablissementController as AdminEtabEtablissementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login',[AuthController::class, 'showFormLogin'])->name('login')->middleware('guest');
Route::post('login',[AuthController::class, 'login'])->name('auth.login');
Route::post('logout',[AuthController::class, 'logout'])->name('logout');


//Acceuil
Route::get('/',[ControllersHomeController::class, 'welcome'])->name('welcome');
Route::get('/etablissements',[ControllersHomeController::class, 'etablissements'])->name('etablissements');
Route::get('/contact',[ControllersHomeController::class, 'contact'])->name('contact');
Route::get('/licenceMaster',[ControllersHomeController::class, 'licenceExcellenceMaster'])->name('welcomeLicenceExcelllenceMaster');
Route::get('/bachelier',[ControllersHomeController::class, 'bacheliers'])->name('bacheliers');
Route::get('/annonce/{actualite}',[ControllersHomeController::class, 'showActualite'])->name('actualite.show');

//Nos Programme formation
Route::get('/nos-formation',[ControllersHomeController::class,'nosFormation'])->name('nosformation');
Route::get('/nos-formation/{etablissement}/master',[ControllersHomeController::class,'nosFormationMaster'])->name('formationMaster');
Route::get('/nos-formation/{etablissement}/licence',[ControllersHomeController::class,'nosFormationLicence'])->name('formationLicence');
Route::get('/nos-formation/{etablissement}/bachelier',[ControllersHomeController::class,'nosFormationBachelier'])->name('formationBachelier');
Route::get('/nos-formation/{id}/master/choix',[ControllersHomeController::class,'nosFormationMasterChosisir'])->name('master.nosformationChoisen');
Route::get('/nos-formation/{id}/licence/choix',[ControllersHomeController::class,'nosFormationLicenceChosisir'])->name('licence.nosformationChoisen');
Route::get('/nos-formation/{id}/bachelier/choix',[ControllersHomeController::class,'nosFormationBachelierChosisir'])->name('bachelier.nosformationChoisen');




//Quick preinscription
Route::get('/preiscnription',[ControllersHomeController::class,'quickpreinscription'])->name('preinscription');

//Master
Route::get('/master/{etablissement}',[ControllersHomeController::class, 'welcomeMaster'])->name('welcomeMaster');
Route::post('/master/{etablissement}',[ControllersHomeController::class, 'welcomeMasterApply'])->name('welcomeMaster.apply');
Route::get('/master/{etablissement}/form',[ControllersHomeController::class, 'welcomeMasterApplyForm'])->name('welcomeMaster.apply.form');


//Licence
Route::get('/licenceExcellence/{etablissement}',[ControllersHomeController::class, 'welcomeLicenceExcellence'])->name('welcomeLicenceExcelllence');
Route::post('/licenceExcellence/{etablissement}',[ControllersHomeController::class, 'welcomeLicenceExcellenceApply'])->name('welcomeLicenceExcelllence.apply');
Route::get('/licenceExcellence/{etablissement}/form',[ControllersHomeController::class, 'welcomeLicenceExcellenceApplyForm'])->name('welcomeLicenceExcelllence.apply.form');


//bac
Route::get('/bachelier/acceeouvert',[ControllersHomeController::class, 'bacheliersAcceOuvert'])->name('bacheliers.acceeOuvert');
Route::get('/bachelier/acceeouvert/{etablissement}/form',[FormBacController::class, 'bacheliersAcceOuvertShowForm'])->name('bacheliers.acceeOuvert.etablissement.showForm');
Route::post('/bachelier/acceeouvert/{etablissement}/form',[FormBacController::class, 'bacheliersAcceOuvertFormApply'])->name('bacheliers.welcomeBacAcceOuvert.apply');
Route::post('/bachelier/acceeouvert/{etablissement}/form/postuler',[FormBacController::class, 'bacheliersAcceOuvertFormApplyFinal'])->name('bacheliers.welcomeBacAcceOuvert.form.apply');



Route::get('/filiere', function () {
    return view('filiere');
});
// Route::get('/pre-inscription', function () {
//     return view('preinscription-master-form');
// });

Route::group(['as'=>'sup-admin.', 'prefix' => 'sup-admin','middleware' => ['auth','isSupAdmin']] ,function () {


    Route::get('/dashboard',[HomeController::class, 'index'])->name('dashboard');
    Route::post('/data/telecharger',[HomeController::class, 'downloadDataByEtab'])->name('data.telecharger.etablissement');
    Route::post('/data/telecharger/filiere', [HomeController::class, 'downloadDataByFiliere'])
    ->name('data.telecharger.filiere');


    //etablissements management
    Route::get('/etablissement',[EtablissementController::class, 'index'])->name('etablissement.index');
    Route::get('/etablissement/create',[EtablissementController::class, 'create'])->name('etablissement.create');
    Route::post('/etablissement/store',[EtablissementController::class, 'store'])->name('etablissement.store');
    Route::get('/etablissement/{etablissement}/edit',[EtablissementController::class, 'edit'])->name('etablissement.edit');
    Route::put('/etablissement/{etablissement}/update',[EtablissementController::class, 'update'])->name('etablissement.update');
    Route::get('/etablissement/{etablissement}/show',[EtablissementController::class, 'show'])->name('etablissement.show');
    Route::delete('/etablissement/{etablissement}/delete',[EtablissementController::class, 'destroy'])->name('etablissement.delete');
    Route::patch('/etablissement/togglePreInscription', [EtablissementController::class, 'togglePreInscription'])->name('etablissement.togglePreInscription');
    Route::post('/etablissement/storemedia',[EtablissementController::class, 'storeMedia'])->name('etablissement.storeMedia');


    Route::post('/etablissement/reponsable/create',[ResponsableController::class, 'store'])->name('responsable.create');



    //Filieres
    Route::get('/etablissement/{etablissement}/filieres',[SupAdminFiliereController::class, 'categorie'])->name('etablissement.categorie.filiere');
    Route::get('/etablissement/master/{filiere}/etudiants',[SupAdminFiliereController::class, 'showEtudiantsMaster'])->name('etablissement.filiere.master.etudiants');
    Route::get('/filiere/{filiere}/master/etudiant/{etudiant}',[SupAdminFiliereController::class, 'showDetailStudentMaster'])->name('filiere.master.etudiants.show');
    Route::get('/etablissement/passerelle/{filiere}/etudiants',[SupAdminFiliereController::class, 'showEtudiantsPasserelle'])->name('etablissement.filiere.passerelle.etudiants');
    Route::get('/filiere/{filiere}/licenceExcellence/etudiant/{etudiant}',[SupAdminFiliereController::class, 'showDetailStudentLicenceExcellence'])->name('filiere.licenceExcellence.etudiants.show');
    Route::get('master/candidats/{candidat}/edit',[SupAdminFiliereController::class, 'editMasterCandidat'])->name('master.candidat.edit');
    Route::put('master/candidats/{candidat}/update',[SupAdminFiliereController::class, 'updateMasterCandidat'])->name('master.candidat.update');
    Route::get('passerelle/candidats/{candidat}/edit',[SupAdminFiliereController::class, 'editPasserelleCandidat'])->name('passerelle.candidat.edit');
    Route::put('passerelle/candidats/{candidat}/update',[SupAdminFiliereController::class, 'updatePasserelleCandidat'])->name('passerelle.candidat.update');
    Route::get('/etablissement/bachelier/{filiere}/etudiants',[SupAdminFiliereController::class, 'showStudentsBacheliers'])->name('etablissement.filiere.bachelier.etudiants');
    Route::get('/filiere/{filiere}/bachelier/etudiant/{etudiant}',[SupAdminFiliereController::class, 'showDetailStudentBachelier'])->name('filiere.bachelier.etudiants.show');
    Route::get('bachelier/candidats/{candidat}/edit',[SupAdminFiliereController::class, 'editBachelierCandidat'])->name('bachelier.candidat.edit');
    Route::put('bachelier/candidats/{candidat}/update',[SupAdminFiliereController::class, 'updateBachelierCandidat'])->name('bachelier.candidat.update');
    Route::post('filiere/{filiere}/active',[SupAdminFiliereController::class, 'activer'])->name('filiere.active');
    Route::post('filiere/{filiere}/desactive',[SupAdminFiliereController::class, 'desactiver'])->name('filiere.desactive');

    
    //Download
    Route::post('/filiere/{filiere}/master/etudiant/excel/download',[SupAdminFiliereController::class, 'downloadStudentsMaster'])->name('filiere.master.etudiants.excel.download');
    Route::post('/filiere/{filiere}/master/etudiant/verified/excel/download',[SupAdminFiliereController::class, 'downloadStudentsVerifiedMaster'])->name('filiere.master.etudiants.verified.excel.download');
    Route::post('/filiere/{filiere}/licence/etudiant/excel/download',[SupAdminFiliereController::class, 'downloadStudentsLicence'])->name('filiere.licence.etudiants.excel.download');
    Route::post('/filiere/{filiere}/licence/etudiant/verified/excel/download',[SupAdminFiliereController::class, 'downloadStudentsVerifiedLicence'])->name('filiere.licence.etudiants.verified.excel.download');
    Route::post('/filiere/{filiere}/bachelier/etudiant/excel/download',[SupAdminFiliereController::class, 'downloadStudentsBachelier'])->name('filiere.bachelier.etudiants.excel.download');
    Route::post('/filiere/{filiere}/bachelier/etudiant/verified/excel/download',[SupAdminFiliereController::class, 'downloadStudentsVerifiedBachelier'])->name('filiere.bachelier.etudiants.verified.excel.download');


    
    
    //actualite management
    Route::get('actualite',[ActualiteController::class, 'index'])->name('actualite.index');
    Route::get('actualite/create',[ActualiteController::class, 'create'])->name('actualite.create');
    Route::post('actualite/store',[ActualiteController::class, 'store'])->name('actualite.store');
    Route::get('actualite/{actualite}/show',[ActualiteController::class, 'show'])->name('actualite.show');
    Route::get('actualite/{actualite}/edit',[ActualiteController::class, 'edit'])->name('actualite.edit');
    Route::put('actualite/{actualite}/update',[ActualiteController::class, 'update'])->name('actualite.update');
    Route::post('/actualite/storemedia',[EtablissementController::class, 'storeMedia'])->name('actualite.storeMedia');


    //User
    Route::get('/user',[UserController::class, 'index'])->name('user.index');
    Route::get('user/create',[UserController::class, 'create'])->name('user.create');
    Route::post('user/store',[UserController::class, 'store'])->name('user.store');
    Route::get('user/{user}/edit',[UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}/update',[UserController::class, 'update'])->name('user.update');
    Route::post('user/{user}/active',[UserController::class, 'activer'])->name('user.active');
    Route::post('user/{user}/desactive',[UserController::class, 'desactiver'])->name('user.desactive');



    //Serie Bac
    Route::get('/serie_bac',[SerieBacController::class, 'index'])->name('serie_bac.index');
    Route::get('serie_bac/create',[SerieBacController::class, 'create'])->name('serie_bac.create');
    Route::post('serie_bac/store',[SerieBacController::class, 'store'])->name('serie_bac.store');
    Route::get('serie_bac/{serie_bac}/edit',[SerieBacController::class, 'edit'])->name('serie_bac.edit');
    Route::put('serie_bac/{serie_bac}/update',[SerieBacController::class, 'update'])->name('serie_bac.update');


    //Serie Bac
    Route::get('/diplomebacplusdeux',[DiplomeBacPlusDeuxController::class, 'index'])->name('diplomebacplusdeux.index');
    Route::get('diplomebacplusdeux/create',[DiplomeBacPlusDeuxController::class, 'create'])->name('diplomebacplusdeux.create');
    Route::post('diplomebacplusdeux/store',[DiplomeBacPlusDeuxController::class, 'store'])->name('diplomebacplusdeux.store');
    Route::get('diplomebacplusdeux/{diplomebacplusdeux}/edit',[DiplomeBacPlusDeuxController::class, 'edit'])->name('diplomebacplusdeux.edit');
    Route::put('diplomebacplusdeux/{diplomebacplusdeux}/update',[DiplomeBacPlusDeuxController::class, 'update'])->name('diplomebacplusdeux.update');



    //Province
    Route::get('/province',[SupAdminProvinceController::class, 'index'])->name('province.index');
    Route::get('/province/create',[SupAdminProvinceController::class, 'create'])->name('province.create');
    Route::post('/province/store',[SupAdminProvinceController::class, 'store'])->name('province.store');
    Route::get('/province/{province}/edit',[SupAdminProvinceController::class, 'edit'])->name('province.edit');
    Route::put('/province/{province}/update',[SupAdminProvinceController::class, 'update'])->name('province.update');


    //Calendrier
    Route::get('calendrier',[CalendrierController::class, 'index'])->name('calendrier.index');
    Route::get('calendrier/create',[CalendrierController::class, 'create'])->name('calendrier.create');
    Route::post('calendrier/store',[CalendrierController::class, 'store'])->name('calendrier.store');
    Route::get('calendrier/{calendrier}/edit',[CalendrierController::class, 'edit'])->name('calendrier.edit');
    Route::put('calendrier/{calendrier}/update',[CalendrierController::class, 'update'])->name('calendrier.update');



    //Profile
    Route::get('/profile',[SupAdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update',[SupAdminProfileController::class, 'update'])->name('profile.update');
});

Route::group(['as'=>'admin-etab.', 'prefix' => 'admin-etab','middleware' => ['auth','isAdminEtab']] ,function () {
    Route::get('/dashboard',[AdminEtabHomeController::class, 'index'])->name('dashboard');
    Route::get('etablissement/parametre',[AdminEtabEtablissementController::class, 'edit'])->name('etablissement.parametre.edit');
    Route::put('etablissement/{etablissement}/parametre/update',[AdminEtabEtablissementController::class, 'update'])->name('etablissement.parametre.update');
    Route::put('etablissement/{etablissement}/parametre/master/update',[AdminEtabEtablissementController::class, 'updateParametreMaster'])->name('etablissement.parametre.master.update');
    Route::put('etablissement/{etablissement}/parametre/passerelle/update',[AdminEtabEtablissementController::class, 'updateParametrePasserelle'])->name('etablissement.parametre.passerelle.update');
    Route::put('etablissement/{etablissement}/parametre/diplomebac/update',[AdminEtabEtablissementController::class, 'updateParametreDiplomeBac'])->name('etablissement.parametre.diplomeBac.update');
    Route::put('etablissement/{etablissement}/parametre/diplomeBacplus2/update',[AdminEtabEtablissementController::class, 'updateParametreDiplomeBacPlus2'])->name('etablissement.parametre.diplomeBacplus2.update');
    Route::post('/etablissement/storemedia',[AdminEtabEtablissementController::class, 'storeMedia'])->name('etablissement.storeMedia');
    Route::get('licence/filiere/AcceeOuvert',[FiliereController::class, 'indexLicenceAcceOuvert'])->name('filiere.licence.acceeouvert.index');
    Route::get('licence/filiere/AcceeRegule',[FiliereController::class, 'indexLicenceAcceRegule'])->name('filiere.licence.acceeregule.index');
    Route::get('bachelier/filiere',[FiliereController::class, 'indexBachelier'])->name('filiere.bachelier.index');
    Route::get('licence-Excellence/filiere',[FiliereController::class, 'indexLicenceExcellence'])->name('filiere.licencexcellence.index');
    Route::get('master/filiere',[FiliereController::class, 'indexMaster'])->name('filiere.master.index');
    Route::get('/filiere/create',[FiliereController::class, 'create'])->name('filiere.create');
    Route::post('/filiere/store',[FiliereController::class, 'store'])->name('filiere.store');
    Route::get('/filiere/{filiere}/show',[FiliereController::class, 'show'])->name('filiere.show');


    Route::get('/filiere/{filiere}/master/etudiant',[FiliereController::class, 'showStudentsMaster'])->name('filiere.master.etudiants.index');
    Route::post('/filiere/{filiere}/master/etudiant/excel/download',[FiliereController::class, 'downloadStudentsMaster'])->name('filiere.master.etudiants.excel.download');
    Route::get('/filiere/{etablissement}/multiplechoix/master/etudiant/excel/download',[FiliereController::class, 'downloadStudentsMasterMultiplechoix'])->name('filiere.multiplechoix.master.etudiants.excel.download');
    Route::get('/filiere/{filiere}/master/etudiant/{etudiant}',[FiliereController::class, 'showDetailStudentMaster'])->name('filiere.master.etudiants.show');
    Route::get('/filiere/{filiere}/master/listStudentsToSelect',[FiliereController::class, 'ShowStudentsMasterToSelect'])->name('filiere.master.etudiants.listToselect');
    Route::get('/filiere/{filiere}/master/etudiant/{etudiant}/valider',[FiliereController::class, 'validerStudentMaster'])->name('filiere.master.etudiant.valider');
    Route::get('/filiere/{filiere}/master/etudiant/{etudiant}/anullerValidation',[FiliereController::class, 'annulerValidationStudentMaster'])->name('filiere.master.etudiant.annulerValidation');



    Route::get('/filiere/{filiere}/licenceExcellence/etudiant',[FiliereController::class, 'showStudentsLicenceExcellence'])->name('filiere.licenceExcellence.etudiants.index');
    Route::get('/filiere/{filiere}/licenceExcellence/etudiant/{etudiant}',[FiliereController::class, 'showDetailStudentLicenceExcellence'])->name('filiere.licenceExcellence.etudiants.show');
    Route::post('/filiere/{filiere}/licenceExcellence/etudiant/excel/download',[FiliereController::class, 'downloadStudentsLicenceExcellence'])->name('filiere.licenceExcellence.etudiants.excel.download');
    Route::get('/filiere/{etablissement}/multiplechoix/licenceExcellence/etudiant/excel/download',[FiliereController::class, 'downloadStudentsLicenceExcellenceMultiplechoix'])->name('filiere.multiplechoix.licenceExcellence.etudiants.excel.download');
    Route::get('/filiere/{filiere}/licenceExcellence/listStudentsToSelect',[FiliereController::class, 'ShowStudentsLicenceExcellenceToSelect'])->name('filiere.licenceExcellence.etudiants.listToselect');
    Route::get('/filiere/{filiere}/licenceExcellence/etudiant/{etudiant}/valider',[FiliereController::class, 'validerStudentLicence'])->name('filiere.licenceExcellence.etudiant.valider');
    Route::get('/filiere/{filiere}/licenceExcellence/etudiant/{etudiant}/anullerValidation',[FiliereController::class, 'annulerValidationStudentLicence'])->name('filiere.licenceExcellence.etudiant.annulerValidation');



    Route::get('/filiere/{filiere}/bachelier/etudiant',[FiliereController::class, 'showStudentsBacheliers'])->name('filiere.bachelier.etudiants.index');
    Route::get('/filiere/{filiere}/bachelier/etudiant/{etudiant}',[FiliereController::class, 'showDetailStudentBachelier'])->name('filiere.bachelier.etudiants.show');
    Route::get('/filiere/{filiere}/bachelier/etudiant/{etudiant}/valider',[FiliereController::class, 'validerStudentBachelier'])->name('filiere.bachelier.etudiant.valider');
    Route::get('/filiere/{filiere}/bachelier/etudiant/{etudiant}/anullerValidation',[FiliereController::class, 'annulerValidationStudentBachelier'])->name('filiere.bachelier.etudiant.annulerValidation');

    

    //payment
    Route::get('payment/master/filiere',[PaymentController::class, 'paymentFiliereMaster'])->name('payment.master.filiere.index');
    Route::get('payment/master/filiere/{filiere}/students',[PaymentController::class, 'paymentFiliereMasterStudents'])->name('payment.master.filiere.students');
    Route::get('payment/master/filiere/{filiere}/student/{etudiant}/show',[PaymentController::class, 'paymentFiliereMasterShowStudent'])->name('payment.master.filiere.student.show');
    Route::post('payment/master/filiere/{filiere}/student/{etudiant}/store',[PaymentController::class, 'paymentFiliereMasterStore'])->name('payment.master.filiere.student.store');
    Route::get('payment/licence/filiere',[PaymentController::class, 'paymentFiliereLicence'])->name('payment.licence.filiere.index');
    Route::get('payment/licence/filiere/{filiere}/students',[PaymentController::class, 'paymentFiliereLicenceStudents'])->name('payment.licence.filiere.students');
    Route::get('payment/licence/filiere/{filiere}/student/{etudiant}/show',[PaymentController::class, 'paymentFiliereLicenceShowStudent'])->name('payment.licence.filiere.student.show');
    Route::post('payment/licence/filiere/{filiere}/student/{etudiant}/store',[PaymentController::class, 'paymentFiliereLicenceStore'])->name('payment.licence.filiere.student.store');
    Route::get('payment/bachelier/filiere',[PaymentController::class, 'paymentFiliereBachelier'])->name('payment.bachelier.filiere.index');
    Route::get('payment/bachelier/filiere/{filiere}/students',[PaymentController::class, 'paymentFiliereBachelierStudents'])->name('payment.bachelier.filiere.students');
    Route::get('payment/bachelier/filiere/{filiere}/student/{etudiant}/show',[PaymentController::class, 'paymentFiliereBachelierShowStudent'])->name('payment.bachelier.filiere.student.show');
    Route::post('payment/bachelier/filiere/{filiere}/student/{etudiant}/store',[PaymentController::class, 'paymentFiliereBachelierStore'])->name('payment.bachelier.filiere.student.store');
    Route::post('/paiement/storemedia',[PaymentController::class, 'storeMedia'])->name('paiement.storeMedia');

    

    Route::get('/filiere/{filiere}/licenceAcceeOuvert/etudiant',[FiliereController::class, 'showStudentsLicenceAcceeOuvert'])->name('filiere.licenceAcceeOuvert.etudiants.index');
    Route::get('/filiere/{filiere}/licenceAcceeOuvert/etudiant/{etudiant}',[FiliereController::class, 'showDetailStudentLicenceAcceeOuvert'])->name('filiere.licenceAcceeOuvert.etudiants.show');
    Route::post('/filiere/{filiere}/licenceAcceeOuvert/etudiant/excel/download',[FiliereController::class, 'downloadStudentsLicenceAcceeOuvert'])->name('filiere.licenceAcceeOuvert.etudiants.excel.download');



    Route::get('licence/filiere/{filiere}/province/edit',[FiliereController::class, 'editProvinceFiliere'])->name('filiere.licence.province.edit');

    Route::get('/filiere/{filiere}/edit',[FiliereController::class, 'edit'])->name('filiere.edit');
    Route::put('/filiere/{filiere}/update',[FiliereController::class, 'update'])->name('filiere.update');
    Route::post('filiere/{filiere}/active',[FiliereController::class, 'activer'])->name('filiere.active');
    Route::post('filiere/{filiere}/desactive',[FiliereController::class, 'desactiver'])->name('filiere.desactive');
    Route::post('/filiere/storemedia',[FiliereController::class, 'storeMedia'])->name('filiere.storeMedia');



    Route::get('/responsable',[AdminEtabResponsableController::class, 'index'])->name('responsable.index');
    Route::post('/filiere/reponsable/create',[AdminEtabResponsableController::class, 'store'])->name('responsable.create');
    Route::get('/edit/{user}/responsable',[AdminEtabResponsableController::class, 'edit'])->name('responsable.edit');
    Route::put('/update/{user}/responsable',[AdminEtabResponsableController::class, 'update'])->name('responsable.update');
    Route::post('responsable/{user}/active',[AdminEtabResponsableController::class, 'activer'])->name('responsable.active');
    Route::post('responsable/{user}/desactive',[AdminEtabResponsableController::class, 'desactiver'])->name('responsable.desactive');



    Route::get('master/candidats/list',[CandidatController::class, 'indexMaster'])->name('master.candidat.index');
    Route::get('master/candidats/{candidat}/',[CandidatController::class, 'showMasterCandidat'])->name('master.candidat.show');
    Route::get('master/candidats/{candidat}/edit',[CandidatController::class, 'editMasterCandidat'])->name('master.candidat.edit');
    Route::put('master/candidats/{candidat}/update',[CandidatController::class, 'updateMasterCandidat'])->name('master.candidat.update');
    Route::get('master/candidats/{candidat}/telechargerRecu',[CandidatController::class, 'telechargrRecuMasterCandidat'])->name('master.candidat.telechargerrecu');
    Route::put('master/candidats/{candidat}/annulerConfirmation',[CandidatController::class, 'annulerConfirmationMasterCandidat'])->name('master.candidat.annulerConfirmation');
    Route::get('passerelle/candidats/list',[CandidatController::class, 'indexPasserelle'])->name('passerelle.candidat.index');
    Route::get('passerelle/candidats/{candidat}/',[CandidatController::class, 'showPasserelleCandidat'])->name('passerelle.candidat.show');
    Route::get('passerelle/candidats/{candidat}/edit',[CandidatController::class, 'editPasserelleCandidat'])->name('passerelle.candidat.edit');
    Route::put('passerelle/candidats/{candidat}/update',[CandidatController::class, 'updatePasserelleCandidat'])->name('passerelle.candidat.update');
    Route::put('passerelle/candidats/{candidat}/annulerConfirmation',[CandidatController::class, 'annulerConfirmationPasserelleCandidat'])->name('passerelle.candidat.annulerConfirmation');
    Route::get('passerelle/candidats/{candidat}/telechargerRecu',[CandidatController::class, 'telechargrRecuPasserelleCandidat'])->name('passerelle.candidat.telechargerrecu');




    //actualite management
    Route::get('actualite',[AdminEtabActualiteController::class, 'index'])->name('actualite.index');
    Route::get('actualite/create',[AdminEtabActualiteController::class, 'create'])->name('actualite.create');
    Route::post('actualite/store',[AdminEtabActualiteController::class, 'store'])->name('actualite.store');
    Route::get('actualite/{actualite}/show',[AdminEtabActualiteController::class, 'show'])->name('actualite.show');
    Route::get('actualite/{actualite}/edit',[AdminEtabActualiteController::class, 'edit'])->name('actualite.edit');
    Route::put('actualite/{actualite}/update',[AdminEtabActualiteController::class, 'update'])->name('actualite.update');
    Route::post('/actualite/storemedia',[AdminEtabActualiteController::class, 'storeMedia'])->name('actualite.storeMedia');



    //notification
    Route::get('/notification/create',[NotificationController::class, 'create'])->name('notification.create');
    Route::post('/notification/store',[NotificationController::class, 'store'])->name('notification.store');


    Route::get('/profile',[AdminEtabProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update',[AdminEtabProfileController::class, 'update'])->name('profile.update');


});


Route::group(['as'=>'admin-filiere.', 'prefix' => 'admin-filiere','middleware' => ['auth','isAdminFiliere']] ,function () {
    Route::get('/dashboard',[AdminFiliereHomeController::class, 'index'])->name('dashboard');

    Route::get('master/filieres',[AdminFiliereFiliereController::class, 'indexMaster'])->name('filiere.master.index');
    Route::get('/filiere/{filiere}/master/etudiant',[AdminFiliereFiliereController::class, 'showStudentsMaster'])->name('filiere.master.etudiants.index');
    Route::post('/filiere/{filiere}/master/etudiant/excel/download',[AdminFiliereFiliereController::class, 'downloadStudentsMaster'])->name('filiere.master.etudiants.excel.download');
    Route::get('/filiere/{filiere}/master/etudiant/{etudiant}',[AdminFiliereFiliereController::class, 'showDetailStudentMaster'])->name('filiere.master.etudiants.show');
    Route::get('/filiere/{filiere}/master/etudiant/{etudiant}/selection',[AdminFiliereFiliereController::class, 'showDetailStudentMasterToSelect'])->name('filiere.master.etudiants.show.selection');
    Route::post('filiere/{filiere}/etudiants/{etudiant}/validation', [AdminFiliereFiliereController::class, 'validerOuRejeterEtudiant'])->name('filiere.etudiant.validation');
    Route::get('/filiere/{filiere}/master/listStudentsToSelect',[AdminFiliereFiliereController::class, 'ShowStudentsMasterToSelect'])->name('filiere.master.etudiants.listToselect');
    Route::post('/filiere/{filiere}/master/DlowloadListStudentsToSelect',[AdminFiliereFiliereController::class, 'DonwloadStudentsMasterToSelect'])->name('filiere.master.etudiants.downloadListToselect');



    Route::get('licenceExcellence/filieres',[AdminFiliereFiliereController::class, 'indexLicenceExcellence'])->name('filiere.licencexcellence.index');
    Route::get('/filiere/{filiere}/show',[AdminFiliereFiliereController::class, 'show'])->name('filiere.show');
    Route::get('/filiere/{filiere}/licenceExcellence/etudiant',[AdminFiliereFiliereController::class, 'showStudentsLicenceExcellence'])->name('filiere.licenceExcellence.etudiants.index');
    Route::get('/filiere/{filiere}/licenceExcellence/etudiant/{etudiant}',[AdminFiliereFiliereController::class, 'showDetailStudentLicenceExcellence'])->name('filiere.licenceExcellence.etudiants.show.selection');
    Route::get('/filiere/{filiere}/licenceExcellence/etudiant/{etudiant}/selection',[AdminFiliereFiliereController::class, 'showDetailStudentLicenceExcellenceToSelect'])->name('filiere.licenceExcellence.etudiants.show');
    Route::post('/filiere/{filiere}/licenceExcellence/etudiant/excel/download',[AdminFiliereFiliereController::class, 'downloadStudentsLicenceExcellence'])->name('filiere.licenceExcellence.etudiants.excel.download');
    Route::get('/filiere/{filiere}/licenceExcellence/listStudentsToSelect',[AdminFiliereFiliereController::class, 'ShowStudentsLicenceExcellenceToSelect'])->name('filiere.licenceExcellence.etudiants.listToselect');
    Route::post('/filiere/{filiere}/licenceExcellence/DlowloadListStudentsToSelect',[AdminFiliereFiliereController::class, 'DonwloadStudentsLicenceExcellenceToSelect'])->name('filiere.licenceExcellence.etudiants.downloadListToselect');


    Route::get('/profile',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update',[ProfileController::class, 'update'])->name('profile.update');

});


Route::group(['as'=>'etudiant.', 'prefix' => 'etudiant','middleware' => ['auth','isStudent']] ,function () {
    Route::get('/dashboard',[EtudiantHomeController::class, 'index'])->name('dashboard');
    Route::get('/candidatures',[CandidatureController::class, 'index'])->name('candidatures.index');

    Route::get('/candidatures/{id}/master/afficher',[CandidatureController::class, 'showMaster'])->name('candidatures.master.show');
    Route::get('/candidatures/{id}/master/edit',[CandidatureController::class, 'editMaster'])->name('candidatures.master.edit');
    Route::put('/candidatures/{id}/master/confirmer',[CandidatureController::class, 'confirmerMaster'])->name('candidatures.master.confirmer');
    Route::post('/candidatures/{id}/master/telecharger',[CandidatureController::class, 'telechargerMaster'])->name('candidatures.master.telecharger');
    Route::put('/candidatures/{etudiant}/master/identite/update',[CandidatureController::class, 'updateMasterIdentite'])->name('candidatures.master.identite.update');
    Route::put('/candidatures/{etudiant}/master/academique/update',[CandidatureController::class, 'updateMasterAcademique'])->name('candidatures.master.academique.update');
    Route::put('/candidatures/{etudiant}/master/document/update',[CandidatureController::class, 'updateMasterDocument'])->name('candidatures.master.document.update');
    Route::put('/candidatures/{etudiant}/master/choixFiliere/update',[CandidatureController::class, 'updateChoixFiliereMaster'])->name('candidatures.master.choixFiliere.update');

    Route::get('/candidatures/{id}/passerelle/afficher',[CandidatureController::class, 'showPasserelle'])->name('candidatures.passerelle.show');
    Route::get('/candidatures/{id}/passerelle/edit',[CandidatureController::class, 'editPasserelle'])->name('candidatures.passerelle.edit');
    Route::put('/candidatures/{id}/passerelle/confirmer',[CandidatureController::class, 'confirmerPasserelle'])->name('candidatures.passerelle.confirmer');
    Route::post('/candidatures/{id}/passerelle/telecharger',[CandidatureController::class, 'telechargerPasserelle'])->name('candidatures.passerelle.telecharger');
    Route::put('/candidatures/{etudiant}/passerelle/identite/update',[CandidatureController::class, 'updatePasserelleIdentite'])->name('candidatures.passerelle.identite.update');
    Route::put('/candidatures/{etudiant}/passerelle/academique/update',[CandidatureController::class, 'updatePasserelleAcademique'])->name('candidatures.passerelle.academique.update');
    Route::put('/candidatures/{etudiant}/passerelle/document/update',[CandidatureController::class, 'updatePasserelleDocument'])->name('candidatures.passerelle.document.update');
    Route::put('/candidatures/{etudiant}/passerelle/choixFiliere/update',[CandidatureController::class, 'updateChoixFilierePasserelle'])->name('candidatures.passerelle.choixFiliere.update');

    Route::get('/candidatures/{id}/bachelier/afficher',[CandidatureController::class, 'showBachelier'])->name('candidatures.bachelier.show');
    Route::get('/candidatures/{id}/bachelier/edit',[CandidatureController::class, 'editBachelier'])->name('candidatures.bachelier.edit');
    Route::put('/candidatures/{id}/bachelier/confirmer',[CandidatureController::class, 'confirmerBachelier'])->name('candidatures.bachelier.confirmer');
    Route::post('/candidatures/{id}/bachelier/telecharger',[CandidatureController::class, 'telechargerBachelier'])->name('candidatures.bachelier.telecharger');
    Route::put('/candidatures/{etudiant}/bachelier/identite/update',[CandidatureController::class, 'updateBachelierIdentite'])->name('candidatures.bachelier.identite.update');
    Route::put('/candidatures/{etudiant}/bachelier/academique/update',[CandidatureController::class, 'updateBachelierAcademique'])->name('candidatures.bachelier.academique.update');
    Route::put('/candidatures/{etudiant}/bachelier/choixFiliere/update',[CandidatureController::class, 'updateChoixFiliereBachelier'])->name('candidatures.bachelier.choixFiliere.update');


    //notification
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notification.show');

});


Route::group(['as'=>'visiteur.', 'prefix' => 'visiteur','middleware' => ['auth','isVisiteur']] ,function () {
    Route::get('/dashboard',[VisiteurHomeController::class, 'index'])->name('dashboard');

    Route::post('/data/telecharger',[VisiteurHomeController::class, 'downloadDataByEtab'])->name('data.telecharger.etablissement');
    Route::post('/data/telecharger/filiere', [VisiteurHomeController::class, 'downloadDataByFiliere'])
    ->name('data.telecharger.filiere');

    Route::get('/profile',[VisiteurProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update',[VisiteurProfileController::class, 'update'])->name('profile.update');
});

Route::get('/secure-file/{hashedPath}', [FileController::class, 'showFile'])->name('secure.file');

Route::get('/candidatures/{encryptedId}/master/telecharger/visiteur', [CandidatureController::class, 'telechargerMasterVisiteur']);
Route::get('/candidatures/{encryptedId}/passerelle/telecharger/visiteur', [CandidatureController::class, 'telechargerPasserelleVisiteur']);
Route::get('/candidatures/{encryptedId}/bachelier/telecharger/visiteur', [CandidatureController::class, 'telechargerBechelierVisiteur']);
