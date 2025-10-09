@extends('admin-etab.layouts.master')
@section('content')
<style>
    /* Glassmorphism Effect */
    .master-settings-card {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 30px;
        transition: 0.3s ease-in-out;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
    }

    .master-settings-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.3);
    }

    /* Header with Modern Gradient */
    .master-header {
        background: linear-gradient(135deg, #0052d4, #4364f7, #6fb1fc);
        color: white;
        padding: 20px;
        border-radius: 20px 20px 0 0;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
    }

    /* Status Display with Smooth Transition */
    .master-status {
        padding: 20px;
        font-weight: bold;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 12px;
        background: #ffffff;
        transition: background 0.3s, color 0.3s;
    }

    .master-status.open {
        background-color: #d1f4d5;
        color: #1b6f34;
        border: 2px solid #1b6f34;
    }

    .master-status.closed {
        background-color: #f8d7da;
        color: #a12a3a;
        border: 2px solid #a12a3a;
    }

    /* Modern Toggle Button */
    #toggleMaster {
        padding: 14px 30px;
        font-size: 16px;
        border-radius: 12px;
        font-weight: bold;
        transition: 0.3s ease-in-out;
        cursor: pointer;
        border: none;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    #toggleMaster.open {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
    }

    #toggleMaster.closed {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    #toggleMaster:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }

    /* Modern Switches */
    .switch-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .switch-card {
        width: 100%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        transition: 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .switch-card:hover {
        transform: translateY(-3px);
    }

    /* Save Button with Hover Effect */
    .master-btn {
        background: linear-gradient(135deg, #0046a5, #006eff);
        color: white;
        font-weight: bold;
        border-radius: 10px;
        padding: 14px 30px;
        font-size: 18px;
        transition: 0.3s;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        width: 100%;
    }

    .master-btn:hover {
        background: linear-gradient(135deg, #006eff, #0046a5);
        transform: scale(1.03);
    }

    /* Modern Toggle Button */
    #togglePasserelle {
        padding: 14px 30px;
        font-size: 16px;
        border-radius: 12px;
        font-weight: bold;
        transition: 0.3s ease-in-out;
        cursor: pointer;
        border: none;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    #togglePasserelle.open {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
    }

    #togglePasserelle.closed {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    #togglePasserelle:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }

        /* Glassmorphism Effect */
    .passerelle-settings-card {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 30px;
        transition: 0.3s ease-in-out;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
    }

    .passerelle-settings-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.3);
    }

    /* Header with Modern Gradient */
    .passerelle-header {
        background: linear-gradient(135deg, #0052d4, #4364f7, #6fb1fc);
        color: white;
        padding: 20px;
        border-radius: 20px 20px 0 0;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
    }

    /* Status Display with Smooth Transition */
    .passerelle-status {
        padding: 20px;
        font-weight: bold;
        text-align: center;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 12px;
        background: #ffffff;
        transition: background 0.3s, color 0.3s;
    }

    .passerelle-status.open {
        background-color: #d1f4d5;
        color: #1b6f34;
        border: 2px solid #1b6f34;
    }

    .passerelle-status.closed {
        background-color: #f8d7da;
        color: #a12a3a;
        border: 2px solid #a12a3a;
    }

    /* Modern Toggle Button */
    #togglePasserelle {
        padding: 14px 30px;
        font-size: 16px;
        border-radius: 12px;
        font-weight: bold;
        transition: 0.3s ease-in-out;
        cursor: pointer;
        border: none;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    #togglePasserelle.open {
        background: linear-gradient(135deg, #28a745, #218838);
        color: white;
    }

    #togglePasserelle.closed {
        background: linear-gradient(135deg, #dc3545, #c82333);
        color: white;
    }

    #togglePasserelle:hover {
        transform: scale(1.05);
        opacity: 0.9;
    }

    /* Modern Switches */
    .passerelle-switch-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
    }

    .passerelle-switch-card {
        width: 100%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 15px;
        border-radius: 12px;
        text-align: center;
        transition: 0.3s ease-in-out;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .passerelle-switch-card:hover {
        transform: translateY(-3px);
    }

    /* Save Button with Hover Effect */
    .passerelle-btn {
        background: linear-gradient(135deg, #0046a5, #006eff);
        color: white;
        font-weight: bold;
        border-radius: 10px;
        padding: 14px 30px;
        font-size: 18px;
        transition: 0.3s;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        width: 100%;
    }

    .passerelle-btn:hover {
        background: linear-gradient(135deg, #006eff, #0046a5);
        transform: scale(1.03);
    }


    .diplome-settings-card {
        background: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        padding: 30px;
        transition: 0.3s ease-in-out;
        box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
    }

    .diplome-settings-card:hover {
        transform: translateY(-5px);
        box-shadow: 0px 15px 40px rgba(0, 0, 0, 0.3);
    }

    /* Header with Modern Gradient */
    .diplome-header {
        background: linear-gradient(135deg, #0052d4, #4364f7, #6fb1fc);
        color: white;
        padding: 20px;
        border-radius: 20px 20px 0 0;
        text-align: center;
        font-size: 20px;
        font-weight: bold;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.1);
    }



    /* === Start serie bac === */
    .serie-card {
        display: block;
        background: white;
        border-radius: 12px;
        padding: 18px;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        position: relative;
        border: 2px solid #ddd;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    /* === Hover Effect for Modern Look === */
    .serie-card:hover {
        transform: translateY(-3px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* === Stylish Checkmark (Hidden by Default) === */
    .checkmark {
        width: 24px;
        height: 24px;
        font-size: 1.5rem;
        color: transparent;
        transition: all 0.3s ease-in-out;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    /* === When Checked: Beautiful Selection Effect === */
    .serie-checkbox:checked + .serie-card {
        background: linear-gradient(135deg, #0066cc, #003366);
        color: white;
        border: 2px solid #003366;
        box-shadow: 0px 10px 30px rgba(0, 102, 204, 0.4);
    }

    /* === Checked Icon (Smooth Animation) === */
    .serie-checkbox:checked + .serie-card .checkmark {
        color: white;
        transform: scale(1);
    }




    /* === Start Diplome Bac+2 === */
    .diplome-card {
        display: block;
        background: white;
        border-radius: 12px;
        padding: 18px;
        text-align: center;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        position: relative;
        border: 2px solid #ddd;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }

    /* === Hover Effect for Modern Look === */
    .diplome-card:hover {
        transform: translateY(-3px);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* === Stylish Checkmark (Hidden by Default) === */
    .checkmark {
        width: 24px;
        height: 24px;
        font-size: 1.5rem;
        color: transparent;
        transition: all 0.3s ease-in-out;
        position: absolute;
        top: 20px;
        right: 10px;
    }

    /* === When Checked: Beautiful Selection Effect for Bac+2 === */
    .diplome-checkbox:checked + .diplome-card {
        background: linear-gradient(135deg, #0066cc, #003366);
        color: white;
        border: 2px solid #003366;
        box-shadow: 0px 10px 30px rgba(0, 102, 204, 0.4);
    }

    /* === Checked Icon (Smooth Animation) === */
    .diplome-checkbox:checked + .diplome-card .checkmark {
        color: white;
        transform: scale(1);
    }

    /* === Diplome Name Styling === */
    .diplome-name {
        display: block;
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-top: 10px;
    }

    /* Hide the actual checkbox */
    .diplome-checkbox {
        display: none;
    }



</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#propos" role="tab"
                          aria-selected="true">A propos</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#master" role="tab"
                          aria-selected="false">Master</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#passerelle" role="tab"
                          aria-selected="false">Licence</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#diplomebac" role="tab"
                          aria-selected="false">Diplomes du Baccalauréat</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#diplomebacplus2" role="tab"
                          aria-selected="false">Diplomes du Bac + 2</a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                        <div class="tab-pane fade show active" id="propos" role="tabpanel" aria-labelledby="home-tab2">
                            <form method="POST" action="{{route('admin-etab.etablissement.parametre.update',['etablissement' => $etablissement->id])}}">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                <h4>Modifier Mon Etablissement</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <label for="">Nom abréviation</label>
                                                    <input type="text" name="nom_abrev" value="{{old('nom_abrev',$etablissement->nom_abrev)}}" class="form-control {{ $errors->has('nom_abrev') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('nom_abrev'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('nom_abrev') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-9">
                                                <div class="form-group">
                                                    <label for="">nom</label>
                                                    <input type="text" name="nom" value="{{old('nom',$etablissement->nom)}}" class="form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('nom'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('nom') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{old('description',$etablissement->description)}}</textarea>
                                                @if($errors->has('description'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('description') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                            <label for="">Logo</label>
                                            <input type="file" class="filepond" name="file" id="filepond" accept="image/png, image/jpeg, image/jpg, image/webp" data-max-file-size="400KB">
                                            @if($errors->has('file'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('file') }}
                                                </div>
                                            @endif
                                        </div>
                                        <button class="btn btn-primary btn-block">Modifier</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="master" role="tabpanel" aria-labelledby="profile-tab2">
                            <form id="masterSettingsForm" method="POST" action="{{ route('admin-etab.etablissement.parametre.master.update',['etablissement' => $etablissement->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card master-settings-card">
                                    <div class="master-header">
                                        <h4><i class="fas fa-cogs"></i> Paramètres du Master</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="master-status {{ $etablissement->master_ouvert ? 'open' : 'closed' }}" id="masterStatus">
                                                    <strong><i class="fas fa-graduation-cap"></i> Master:</strong>
                                                    <span id="masterState">{{ $etablissement->master_ouvert ? 'Ouvert' : 'Fermé' }}</span>
                                                    <button type="button" id="toggleMaster" class="{{ $etablissement->master_ouvert ? 'open' : 'closed' }}">
                                                        {{ $etablissement->master_ouvert ? 'Fermer le Master' : 'Ouvrir le Master' }}
                                                    </button>
                                                </div>
                                                <input type="hidden" name="master_ouvert" id="master_ouvert" value="{{ $etablissement->master_ouvert ? 1 : 0 }}">
                                            </div>

                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-layer-group"></i> Multiple choix(Filieres)</h6>
                                                    <input type="checkbox" id="show_multiple" name="multiple_choix_filiere_master" {{ $etablissement->multiple_choix_filiere_master ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-file-alt"></i> Afficher l’importation du diplôme de baccalauréat</h6>
                                                    <input type="checkbox" id="show_bac" name="show_bac_input_master" {{ $etablissement->show_bac_input_master ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-file-alt"></i> Afficher l’importation du diplôme de licence</h6>
                                                    <input type="checkbox" id="show_licence" name="show_licence_input_master" {{ $etablissement->show_licence_input_master ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-id-card"></i> Afficher CIN</h6>
                                                    <input type="checkbox" id="show_cin" name="show_cin_input_master" {{ $etablissement->show_cin_input_master ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-camera"></i> Afficher Photo</h6>
                                                    <input type="checkbox" id="show_photo" name="show_photo_input_master" {{ $etablissement->show_photo_input_master ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-file-alt"></i> Afficher l’importation d'attestation du non-emploi</h6>
                                                    <input type="checkbox" id="show_attestation_non_emploi" name="show_attestation_no_emploi_input_master" {{ $etablissement->show_attestation_no_emploi_input_master ? 'checked' : '' }}>
                                                </div>
                                            </div>
                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-file-alt"></i> Afficher CV</h6>
                                                    <input type="checkbox" id="show_cv" name="show_cv_input_master" {{ $etablissement->show_cv_input_master ? 'checked' : '' }}>
                                                </div>
                                            </div>


                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn master-btn"><i class="fas fa-save"></i> Sauvegarder</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="passerelle" role="tabpanel" aria-labelledby="profile-tab2">
                            <form id="passerelleSettingsForm" method="POST" action="{{ route('admin-etab.etablissement.parametre.passerelle.update',['etablissement' => $etablissement->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card passerelle-settings-card">
                                    <div class="passerelle-header">
                                        <h4><i class="fas fa-cogs"></i> Paramètres du Licence</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-4">
                                                <div class="passerelle-status {{ $etablissement->passerelle_ouvert ? 'open' : 'closed' }}" id="PasserelleStatus">
                                                    <strong><i class="fas fa-graduation-cap"></i> Licence:</strong>
                                                    <span id="passerelleState">{{ $etablissement->passerelle_ouvert ? 'Ouvert' : 'Fermé' }}</span>
                                                    <button type="button" id="togglePasserelle" class="{{ $etablissement->passerelle_ouvert ? 'open' : 'closed' }}">
                                                        {{ $etablissement->passerelle_ouvert ? "Fermer la Licence" : "Ouvrir la Licence" }}
                                                    </button>
                                                </div>
                                                {{-- Hidden input to store the toggle state --}}
                                                <input type="hidden" name="passerelle_ouvert" id="passerelle_ouvert" value="{{ $etablissement->passerelle_ouvert ? 1 : 0 }}">
                                            </div>

                                            {{-- Checkboxes with hidden inputs --}}
                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-layer-group"></i>Multiple choix(Filieres)</h6>
                                                    <input type="hidden" name="multiple_choix_filiere_passerelle" value="0">
                                                    <input type="checkbox" id="show_multiple" name="multiple_choix_filiere_passerelle" value="1" {{ $etablissement->multiple_choix_filiere_passerelle ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            {{-- Checkboxes with hidden inputs --}}
                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-id-card"></i> Afficher l’importation du diplôme de baccalauréat</h6>
                                                    <input type="hidden" name="show_bac_input_passerelle" value="0">
                                                    <input type="checkbox" id="show_bac" name="show_bac_input_passerelle" value="1" {{ $etablissement->show_bac_input_passerelle ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-id-card"></i> Afficher CIN</h6>
                                                    <input type="hidden" name="show_cin_input_passerelle" value="0">
                                                    <input type="checkbox" id="show_cin" name="show_cin_input_passerelle" value="1" {{ $etablissement->show_cin_input_passerelle ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-camera"></i> Afficher Photo</h6>
                                                    <input type="hidden" name="show_photo_input_passerelle" value="0">
                                                    <input type="checkbox" id="show_photo" name="show_photo_input_passerelle" value="1" {{ $etablissement->show_photo_input_passerelle ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-file-alt"></i> Afficher l’importation du diplôme de bac+2</h6>
                                                    <input type="hidden" name="show_diplome_deug_input_passerelle" value="0">
                                                    <input type="checkbox" id="show_diplome_deug" name="show_diplome_deug_input_passerelle" value="1" {{ $etablissement->show_diplome_deug_input_passerelle ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-file-alt"></i> Afficher l’importation d'attestation non-emploi</h6>
                                                    <input type="hidden" name="show_attestation_no_emploi_input_passerelle" value="0">
                                                    <input type="checkbox" id="show_attestation_non_emploi" name="show_attestation_no_emploi_input_passerelle" value="1" {{ $etablissement->show_attestation_no_emploi_input_passerelle ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="col-md-3 switch-container">
                                                <div class="switch-card">
                                                    <h6><i class="fas fa-file-alt"></i> Afficher CV</h6>
                                                    <input type="hidden" name="show_cv_input_passerelle" value="0">
                                                    <input type="checkbox" id="show_cv" name="show_cv_input_passerelle" value="1" {{ $etablissement->show_cv_input_passerelle ? 'checked' : '' }}>
                                                </div>
                                            </div>

                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn passerelle-btn"><i class="fas fa-save"></i> Sauvegarder</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="diplomebac" role="tabpanel" aria-labelledby="profile-tab2">
                            <form id="DiplomeBacSettingsForm" method="POST" action="{{ route('admin-etab.etablissement.parametre.diplomeBac.update',['etablissement' => $etablissement->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card diplome-settings-card">
                                    <div class="diplome-header">
                                        <h4><i class="fas fa-cogs"></i> Paramètres des diplômes du baccalauréat</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-12 text-center mt-4">
                                                <h3 class="mb-4 text-primary fw-bold">Sélectionnez les séries du Bac à afficher</h3>
                                            </div>

                                            @foreach($serieBac as $serie)
                                                <div class="col-md-4 col-lg-3 mb-4">
                                                    <input type="checkbox" id="serie_bac_{{ $serie->id }}" class="serie-checkbox d-none"
                                                        name="serie_bac[]" value="{{ $serie->id }}"
                                                        @if(isset($etablissement) && $etablissement->serie_bac->contains('id', $serie->id)) checked @endif>

                                                    <label for="serie_bac_{{ $serie->id }}" class="serie-card">
                                                        <div class="checkmark">
                                                            <i class="fas fa-check-circle"></i>
                                                        </div>
                                                        <span class="serie-name">{{ $serie->nom }}</span>
                                                    </label>
                                                </div>
                                            @endforeach

                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn passerelle-btn"><i class="fas fa-save"></i> Sauvegarder</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="diplomebacplus2" role="tabpanel" aria-labelledby="profile-tab2">
                            <form id="DiplomeBacplus2SettingsForm" method="POST" action="{{ route('admin-etab.etablissement.parametre.diplomeBacplus2.update',['etablissement' => $etablissement->id]) }}">
                                @csrf
                                @method('PUT')
                                <div class="card diplome-settings-card">
                                    <div class="diplome-header">
                                        <h4><i class="fas fa-cogs"></i> Paramètres des diplômes Bac + 2</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row justify-content-center">
                                            <div class="col-12 text-center mt-4">
                                                <h3 class="mb-4 text-primary fw-bold">Sélectionnez les diplomes à afficher</h3>
                                            </div>

                                            @foreach($diplomeBacplus2 as $diplome)
                                                <div class="col-md-4 col-lg-3 mb-4">
                                                    <input type="checkbox" id="diplome_bac_deux_{{ $diplome->id }}" class="diplome-checkbox d-none"
                                                        name="diplome_bac2[]" value="{{ $diplome->id }}"
                                                        @if(isset($etablissement) && $etablissement->diplomebacplus2->contains('id', $diplome->id)) checked @endif>

                                                    <label for="diplome_bac_deux_{{ $diplome->id }}" class="diplome-card">
                                                        <div class="checkmark">
                                                            <i class="fas fa-check-circle"></i>
                                                        </div>
                                                        <span class="diplome-name">{{ $diplome->nom }}</span>
                                                    </label>
                                                </div>
                                            @endforeach



                                            <div class="col-12 text-center mt-4">
                                                <button type="submit" class="btn passerelle-btn"><i class="fas fa-save"></i> Sauvegarder</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                  </div>
                </div>
              </div>
        </div>
    </section>
</div>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script>
        const input = document.querySelector('input[id="filepond"]');

        FilePond.registerPlugin(
            FilePondPluginFileValidateType,
        );
        const pond=FilePond.create(input,
            {
            labelIdle: `Déposez le logo ici`,
            labelFileProcessing: 'Traitement en cours',
            labelFileProcessingComplete: 'Traitement terminé',
            labelFileProcessingAborted: 'Traitement annulé',
            labelFileProcessingError: 'Erreur de traitement',
            labelTapToCancel: 'Appuyez pour annuler',
            labelTapToRetry: 'Appuyez pour réessayer',
            labelTapToUndo: 'Appuyez pour annuler',
            labelButtonRemoveItem: 'Supprimer',
            labelFileTypeNotAllowed: 'Type de fichier non autorisé. Seuls les fichiers png, jpeg, jpg, webp sont autorisés.'
            }
        );


        // pond.addFile(mainPictureUrl);
        FilePond.setOptions({
            server:{
                url:'{{ route('admin-etab.etablissement.storeMedia') }}',
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },

            },
            success: function (file, response) {
                console.log(response.name)
                $('form').append('<input type="hidden" name="file[]" value="' + response.name + '">')

            },

        });
    </script>
    <script>
       $(document).ready(function () {
            $('#toggleMaster').click(function () {
                let currentState = $('#masterState').text().trim();
                let newState = (currentState === 'Ouvert') ? 'Fermé' : 'Ouvert';
                let newValue = (newState === 'Ouvert') ? 1 : 0;

                // Change text and update hidden input
                $('#masterState').text(newState);
                $('#master_ouvert').val(newValue);  // Update the hidden input value

                // Change button and status class
                if (newState === 'Ouvert') {
                    $('#toggleMaster').removeClass('closed').addClass('open').text('Fermer le Master');
                    $('#masterStatus').removeClass('closed').addClass('open');
                } else {
                    $('#toggleMaster').removeClass('open').addClass('closed').text('Ouvrir le Master');
                    $('#masterStatus').removeClass('open').addClass('closed');
                }

                // Add smooth effect
                $('#masterStatus').fadeOut(150).fadeIn(150);
            });

            $('#togglePasserelle').click(function () {
                let currentState = $('#passerelleState').text().trim();
                let newState = (currentState === 'Ouvert') ? 'Fermé' : 'Ouvert';
                let newValue = (newState === 'Ouvert') ? 1 : 0;

                // Change text and update hidden input
                $('#passerelleState').text(newState);
                $('#passerelle_ouvert').val(newValue);  // Update the hidden input value

                // Change button and status class
                if (newState === 'Ouvert') {
                    $('#togglePasserelle').removeClass('closed').addClass('open').text("Fermer la Licence");
                    $('#PasserelleStatus').removeClass('closed').addClass('open');
                } else {
                    $('#togglePasserelle').removeClass('open').addClass('closed').text("Ouvrir la Licence");
                    $('#PasserelleStatus').removeClass('open').addClass('closed');
                }

                // Add smooth effect
                $('#PasserelleStatus').fadeOut(150).fadeIn(150);
            });
        });


    </script>
   {{-- <script>
        $(document).ready(function () {
            $('#buttonClickResponsable').on('click', function () {
                // Get field values
                let name = $("#name").val().trim();
                let email = $("#email").val().trim();
                let phone = $("#phone").val().trim();
                let password = $("#password").val().trim();

                // Flag to track validation status
                let isValid = true;

                // Clear previous errors
                $(".form-control").removeClass("is-invalid");
                $(".form-group .error-message").remove();

                // Check each field and display error if empty
                if (!name) {
                setInvalid("#name", "Ce champ est requis.");
                isValid = false;
                }
                if (!email) {
                    setInvalid("#email", "Ce champ est requis.");
                    isValid = false;
                } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(email)) {
                    setInvalid("#email", "Veuillez entrer un email valide.");
                    isValid = false;
                }
                if (!phone) {
                    setInvalid("#phone", "Ce champ est requis.");
                    isValid = false;
                } else if (!/^\d{10}$/.test(phone)) {
                    setInvalid("#phone", "Veuillez entrer un numéro de téléphone valide (10 chiffres).");
                    isValid = false;
                }
                if (!password) {
                    setInvalid("#password", "Ce champ est requis.");
                    isValid = false;
                } else if (!/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*])[A-Za-z\d!@#$%^&*]{8,}$/.test(password)) {
                    setInvalid("#password", "Le mot de passe doit être d'au moins 8 caractères, contenir des majuscules, des minuscules, un chiffre et un caractère spécial.");
                    isValid = false;
                }

                // If not valid, block the function
                if (!isValid) {
                    return;
                }

                // Proceed with AJAX request if all fields are valid
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var url = '{{ route("admin-etab.responsable.create") }}';

                $.ajax({
                    type: 'POST', // Change to POST method
                    url: url,
                    data: {
                        _token: CSRF_TOKEN,
                        name: name,
                        email: email,
                        telephone: phone,
                        password: password
                    },
                    dataType: 'JSON',
                    success: function (results) {
                       console.log(results)
                        // Clear the form fields
                        $('#name').val('');
                        $('#email').val('');
                        $('#phone').val('');
                        $('#password').val('');

                        // Close the modal
                        $('#createResponsableModal').modal('hide');
                        $('#responsable_id').append(results.option);
                        Swal.fire("Success!", results.message, "success");
                    },
                    error: function (error) {
                        // Check if the response contains validation errors
                        if (error.status === 422) { // 422 Unprocessable Entity
                            let errors = error.responseJSON.errors;
                            let errorMessage = '';

                            // Loop through the errors and concatenate them
                            for (let field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    errorMessage += `${errors[field].join('<br>')}<br>`;
                                }
                            }

                            // Display the errors in SweetAlert
                            Swal.fire({
                                icon: "error",
                                title: "Erreur de validation!",
                                html: errorMessage, // Use HTML to format the messages
                            });
                        } else {
                            // For other errors, display a generic message
                            Swal.fire("Erreur!", "Refaire cette action après", "error");
                            console.log(error); // Log the error for debugging
                        }
                    }
                });
            });

            $(".form-control").on("input", function () {
                $(this).removeClass("is-invalid"); // Remove red border
                $(this).closest(".form-group").find(".error-message").remove(); // Remove error message
            });

            // Function to set field as invalid and display error message
            function setInvalid(selector, message) {
                // Add is-invalid class to input field
                $(selector).addClass("is-invalid");

                // Append error message below the input field
                $(selector)
                    .closest(".input-group") // Ensure correct placement in the input group
                    .after(`<small class="error-message text-danger">${message}</small>`);
            }
        });
    </script> --}}


@endsection
