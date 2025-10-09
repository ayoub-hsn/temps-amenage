@extends('etudiant.layouts.master')
@section('content')

<style>
    .preview-img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border: 2px solid #ddd;
        border-radius: 10px;
        padding: 5px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }

    .preview-img:hover {
        transform: scale(1.05);
    }
</style>
<style>
    .custom-file-input-wrapper {
        position: relative;
        width: 100%;
    }

    .custom-file-input {
        opacity: 0;
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        z-index: 2;
    }

    .custom-file-label {
        display: block;
        width: 100%;
        padding: 12px 15px;
        background-color: #f0f4f8;
        border: 2px dashed #ccc;
        border-radius: 10px;
        font-weight: 500;
        color: #555;
        text-align: center;
        transition: 0.3s ease all;
        position: relative;
        z-index: 1;
    }

    .custom-file-label:hover {
        background-color: #e0e7ef;
        border-color: #007bff;
        color: #007bff;
    }

    .custom-file-label i {
        margin-right: 8px;
        color: #007bff;
    }

    .preview-img {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 10px;
        border: 2px solid #eee;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        transition: transform 0.3s ease;
    }

    .preview-img:hover {
        transform: scale(1.05);
    }
</style>
<style>
    input[type=checkbox], input[type=radio] {
        position: relative;
    }
    .title {
        font-size: 2rem;
        font-weight: 700;
        color: #004080;
        text-transform: uppercase;
        margin-bottom: 1.5rem;
    }

    .filiere-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        padding-bottom: 2rem;
    }

    .filiere-card {
        background-color: #fff;
        border-radius: 12px;
        padding: 1.5rem;
        position: relative;
        box-shadow: 0 8px 20px rgba(0, 64, 128, 0.1);
        transition: all 0.3s ease-in-out;
        overflow: hidden;
        border: 2px solid transparent;
    }

    .filiere-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 64, 128, 0.15);
        border-color: #007bff;
    }

    .filiere-radio,
    .filiere-checkbox {
        position: absolute;
        top: 1rem;
        left: 1rem;
        transform: scale(1.5);
        cursor: pointer;
    }

    .filiere-name {
        font-size: 1.3rem;
        font-weight: 600;
        color: #003366;
        margin-top: 1.2rem;
        margin-left: 2.5rem;
    }

    .filiere-full {
        font-size: 1rem;
        color: #555;
        margin-left: 2.5rem;
    }

    .doc-link {
        display: inline-block;
        margin-top: 1rem;
        font-size: 1rem;
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .doc-link:hover {
        text-decoration: underline;
    }

    .badge-choix {
        position: absolute;
        top: 12px;
        right: 12px;
        background-color: #28a745;
        color: white;
        font-size: 0.9rem;
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: bold;
        z-index: 2;
    }

    .btn-primary {
        background-color: #004080;
        border: none;
        border-radius: 25px;
        padding: 12px 35px;
        font-size: 1.1rem;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #003366;
        transform: scale(1.05);
    }

    .filiere-card .form-check-input:checked + .filiere-name {
        color: #28a745;
        font-weight: bold;
    }

    .filiere-card .form-check-input:checked + .filiere-name + .filiere-full {
        font-style: italic;
        color: #555;
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
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#identite" role="tab"
                          aria-selected="true">IDENTITE</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#informationacademique" role="tab"
                          aria-selected="false">INFORMATIONS ACADEMIQUES</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#document" role="tab"
                          aria-selected="false">DOCUMENT</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#choixFiliere" role="tab"
                          aria-selected="false">CHOIX DE FILIERE</a>
                      </li>
                     
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                        <div class="tab-pane fade show active" id="identite" role="tabpanel" aria-labelledby="home-tab2">
                            <form method="POST" action="{{route('etudiant.candidatures.passerelle.identite.update',['etudiant' => $etudiant->id])}}">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                <h4>Modifier Mon Identité</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="CNE">CNE</label>
                                                <input type="text" name="CNE" value="{{ old('CNE',$etudiant->CNE) }}" class="form-control {{ $errors->has('CNE') ? 'is-invalid' : '' }}" disabled>
                                                @if($errors->has('CNE'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('CNE') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="CIN">CIN</label>
                                                <input type="text" name="CIN" value="{{ old('CIN',$etudiant->CIN) }}" class="form-control {{ $errors->has('CIN') ? 'is-invalid' : '' }}" disabled>
                                                @if($errors->has('CIN'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('CIN') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="nom">Nom</label>
                                                <input type="text" name="nom" value="{{ old('nom',$etudiant->nom) }}" class="form-control {{ $errors->has('nom') ? 'is-invalid' : '' }}">
                                                @if($errors->has('nom'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('nom') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="prenom">Prénom</label>
                                                <input type="text" name="prenom" value="{{ old('prenom',$etudiant->prenom) }}" class="form-control {{ $errors->has('prenom') ? 'is-invalid' : '' }}">
                                                @if($errors->has('prenom'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('prenom') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group text-right" style="direction: rtl;">
                                                <label for="nomar">الاسم العائلي</label>
                                                <input type="text" name="nomar" value="{{ old('nomar', $etudiant->nomar) }}"
                                                    class="form-control {{ $errors->has('nomar') ? 'is-invalid' : '' }}">
                                                @if($errors->has('nomar'))
                                                    <div class="invalid-feedback text-right">
                                                        {{ $errors->first('nomar') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-6">
                                            <div class="form-group text-right" style="direction: rtl;">
                                                <label for="prenomar">الاسم الشخصي</label>
                                                <input type="text" name="prenomar" value="{{ old('prenomar', $etudiant->prenomar) }}"
                                                    class="form-control {{ $errors->has('prenomar') ? 'is-invalid' : '' }}">
                                                @if($errors->has('prenomar'))
                                                    <div class="invalid-feedback text-right">
                                                        {{ $errors->first('prenomar') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="datenais">datenais</label>
                                                <input type="date" name="datenais" value="{{ old('datenais',$etudiant->datenais) }}" class="form-control {{ $errors->has('datenais') ? 'is-invalid' : '' }}">
                                                @if($errors->has(''))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('datenais') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="sexe">Sexe</label>
                                                <select name="sexe" class="form-control {{ $errors->has('sexe') ? 'is-invalid' : '' }}">
                                                    <option value="M" {{ old('sexe',$etudiant->sexe) == 'M' ? 'selected' : '' }}>Homme</option>
                                                    <option value="F" {{ old('sexe',$etudiant->sexe) == 'F' ? 'selected' : '' }}>Femme</option>
                                                </select>
                                                @if($errors->has('sexe'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('sexe') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="payschamp">Pays</label>
                                                <input type="text" name="payschamp" value="{{ old('payschamp',$etudiant->payschamp) }}" class="form-control {{ $errors->has('payschamp') ? 'is-invalid' : '' }}">
                                                @if($errors->has('payschamp'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('payschamp') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                

                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="villenais">Vaille Naissance</label>
                                                <input type="text" name="villenais" value="{{ old('villenais', $etudiant->villenais) }}"
                                                    class="form-control {{ $errors->has('villenais') ? 'is-invalid' : '' }}">
                                                @if($errors->has('villenais'))
                                                    <div class="invalid-feedback text-right">
                                                        {{ $errors->first('villenais') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group text-right" style="direction: rtl;">
                                                <label for="villenais" class="rtl-label">مكان الازدياد</label>
                                                <input type="text" name="villechamp" value="{{ old('villechamp',$etudiant->villechamp) }}" class="form-control {{ $errors->has('villechamp') ? 'is-invalid' : '' }}">
                                                @if($errors->has('villechamp'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('villechamp') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="adresse">Adresse</label>
                                                <input type="text" name="adresse" value="{{ old('adresse',$etudiant->adresse) }}" class="form-control {{ $errors->has('adresse') ? 'is-invalid' : '' }}">
                                                @if($errors->has('adresse'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('adresse') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" value="{{ old('email',$etudiant->email) }}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" disabled>
                                                @if($errors->has('email'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="phone">Téléphone</label>
                                                <input type="text" name="phone" value="{{ old('phone',$etudiant->phone) }}" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}">
                                                @if($errors->has('phone'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('phone') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <button class="btn btn-primary btn-block">Modifier</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="informationacademique" role="tabpanel" aria-labelledby="profile-tab2">
                            <form method="POST" action="{{route('etudiant.candidatures.passerelle.academique.update',['etudiant' => $etudiant->id])}}">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                <h4>Modifier Mes Information Académique</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                            <!-- Serie de BAC -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="serie">Série de BAC</label>
                                                    <input type="text" name="serie" value="{{ old('serie',$etudiant->serie) }}" class="form-control {{ $errors->has('serie') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('serie'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('serie') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                            <!-- Date d'obtention du BAC -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="Anneebac">Date d'obtention du BAC</label>
                                                    <input type="date" name="Anneebac" value="{{ old('Anneebac',$etudiant->Anneebac) }}" class="form-control {{ $errors->has('Anneebac') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('Anneebac'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('Anneebac') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                        
                                        <!-- Derniere diplome Information -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="dernier_diplome_obtenu">Dernier Diplome Obtenu</label>
                                                <select name="dernier_diplome_obtenu" class="form-control {{ $errors->has('dernier_diplome_obtenu') ? 'is-invalid' : '' }}">
                                                    <option value="BAC+3" {{ old('dernier_diplome_obtenu',$etudiant->dernier_diplome_obtenu) == "BAC+3" ? 'selected' : '' }}>Bac+3</option>
                                                    <option value="BAC+4" {{ old('dernier_diplome_obtenu',$etudiant->dernier_diplome_obtenu) == "BAC+4" ? 'selected' : '' }}>Bac+4</option>
                                                    <option value="BAC+5" {{ old('dernier_diplome_obtenu',$etudiant->dernier_diplome_obtenu) == "BAC+5" ? 'selected' : '' }}>Bac+5</option>
                                                </select>
                                                @if($errors->has('dernier_diplome_obtenu'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('dernier_diplome_obtenu') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <!-- Type du Diplome -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="type_diplome_obtenu">Type du Diplome</label>
                                                <input type="text" name="type_diplome_obtenu" value="{{ old('type_diplome_obtenu',$etudiant->type_diplome_obtenu) }}" class="form-control {{ $errors->has('type_diplome_obtenu') ? 'is-invalid' : '' }}">
                                                @if($errors->has('type_diplome_obtenu'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('type_diplome_obtenu') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <!-- Spécialité du Diplome -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="specialitediplome">Spécialité du Diplome</label>
                                                <input type="text" name="specialitediplome" value="{{ old('specialitediplome',$etudiant->specialitediplome) }}" class="form-control {{ $errors->has('specialitediplome') ? 'is-invalid' : '' }}">
                                                @if($errors->has('specialitediplome'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('specialitediplome') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        {{-- <!-- Etablissement Bac+2 -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="etblsmtdeug">Etablissement Bac+2</label>
                                                <input type="text" name="etblsmtdeug" value="{{ old('etblsmtdeug',$etudiant->etblsmtdeug) }}" class="form-control {{ $errors->has('etblsmtdeug') ? 'is-invalid' : '' }}">
                                                @if($errors->has('etblsmtdeug'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('etblsmtdeug') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div> --}}
                                    
                                        <!-- Ville d'établissement du diplome -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="ville_etablissement_diplome">Ville d'établissement</label>
                                                <input type="text" name="ville_etablissement_diplome" value="{{ old('ville_etablissement_diplome',$etudiant->ville_etablissement_diplome) }}" class="form-control {{ $errors->has('ville_etablissement_diplome') ? 'is-invalid' : '' }}">
                                                @if($errors->has('ville_etablissement_diplome'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('ville_etablissement_diplome') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                        <!-- Date d'obtention de Diplome -->
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="date_optention_diplome">Date d'obtention du Diplome</label>
                                                <input type="date" name="date_optention_diplome" value="{{ old('date_optention_diplome',$etudiant->date_optention_diplome) }}" class="form-control {{ $errors->has('date_optention_diplome') ? 'is-invalid' : '' }}">
                                                @if($errors->has('date_optention_diplome'))
                                                    <div class="invalid-feedback">
                                                        {{ $errors->first('date_optention_diplome') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    
                                            <!-- Fonctionnaire -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="fonctionnaire">Fonctionnaire</label>
                                                    <select name="fonctionnaire" class="form-control {{ $errors->has('fonctionnaire') ? 'is-invalid' : '' }}">
                                                        <option value="">-- Sélectionner --</option>
                                                        <option value="1" {{ old('fonctionnaire', $etudiant->fonctionnaire) == '1' ? 'selected' : '' }}>Oui</option>
                                                        <option value="0" {{ old('fonctionnaire', $etudiant->fonctionnaire) == '0' ? 'selected' : '' }}>Non</option>
                                                    </select>
                                                    @if($errors->has('fonctionnaire'))
                                                        <div class="invalid-feedback">{{ $errors->first('fonctionnaire') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Secteur -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="secteur">Secteur</label>
                                                    <input type="text" name="secteur" value="{{ old('secteur', $etudiant->secteur) }}" class="form-control {{ $errors->has('secteur') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('secteur'))
                                                        <div class="invalid-feedback">{{ $errors->first('secteur') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Nombre d'années -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="nombreannee">Nombre d'années</label>
                                                    <input type="number" name="nombreannee" value="{{ old('nombreannee', $etudiant->nombreannee) }}" class="form-control {{ $errors->has('nombreannee') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('nombreannee'))
                                                        <div class="invalid-feedback">{{ $errors->first('nombreannee') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Poste -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="poste">Poste</label>
                                                    <input type="text" name="poste" value="{{ old('poste', $etudiant->poste) }}" class="form-control {{ $errors->has('poste') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('poste'))
                                                        <div class="invalid-feedback">{{ $errors->first('poste') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Lieu de travail -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="lieutravail">Lieu de travail</label>
                                                    <input type="text" name="lieutravail" value="{{ old('lieutravail', $etudiant->lieutravail) }}" class="form-control {{ $errors->has('lieutravail') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('lieutravail'))
                                                        <div class="invalid-feedback">{{ $errors->first('lieutravail') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <!-- Ville de travail -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="villetravail">Ville de travail</label>
                                                    <input type="text" name="villetravail" value="{{ old('villetravail', $etudiant->villetravail) }}" class="form-control {{ $errors->has('villetravail') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('villetravail'))
                                                        <div class="invalid-feedback">{{ $errors->first('villetravail') }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                          


                                        <div class="col-lg-12">
                                            <button class="btn btn-primary btn-block">Modifier</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </form>         
                        </div> 
                        
                        <div class="tab-pane fade" id="document" role="tabpanel" aria-labelledby="profile-tab2">
                            <form method="POST" action="{{route('etudiant.candidatures.passerelle.document.update',['etudiant' => $etudiant->id])}}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="card-header">
                                <h4>Modifier Mes Documents</h4>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                            
                                        @if ($etablissement->show_photo_input_passerelle)
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="path_photo">Photo</label>
                                                    <div class="custom-file-input-wrapper">
                                                        <input type="file" name="path_photo" id="path_photo" class="custom-file-input {{ $errors->has('path_photo') ? 'is-invalid' : '' }}" onchange="previewImage(this)">
                                                        <label class="custom-file-label" for="path_photo"><i class="fas fa-upload"></i> Choisir une image</label>
                                                    </div>
                                                    @if($errors->has('path_photo'))
                                                        <div class="invalid-feedback d-block">{{ $errors->first('path_photo') }}</div>
                                                    @endif
                                                    <div class="mt-2">
                                                        <img src="{{ asset($etudiant->path_photo) }}" alt="Photo" class="preview-img" id="preview_path_photo">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($etablissement->show_cin_input_passerelle)   
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="path_cin">CIN</label>
                                                    <div class="custom-file-input-wrapper">
                                                        <input type="file" name="path_cin" id="path_cin" class="custom-file-input {{ $errors->has('path_cin') ? 'is-invalid' : '' }}" onchange="previewImage(this)">
                                                        <label class="custom-file-label" for="path_cin"><i class="fas fa-upload"></i> Choisir une image</label>
                                                    </div>
                                                    @if($errors->has('path_cin'))
                                                        <div class="invalid-feedback d-block">{{ $errors->first('path_cin') }}</div>
                                                    @endif
                                                    <div class="mt-2">
                                                        <img src="{{ asset($etudiant->path_cin) }}" alt="CIN" class="preview-img" id="preview_path_cin">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($etablissement->show_bac_input_passerelle)   
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="path_bac">Diplome Du Baccalauréat</label>
                                                    <div class="custom-file-input-wrapper">
                                                        <input type="file" name="path_bac" id="path_bac" class="custom-file-input {{ $errors->has('path_bac') ? 'is-invalid' : '' }}" onchange="previewImage(this)">
                                                        <label class="custom-file-label" for="path_bac"><i class="fas fa-upload"></i> Choisir une image</label>
                                                    </div>
                                                    @if($errors->has('path_bac'))
                                                        <div class="invalid-feedback d-block">{{ $errors->first('path_bac') }}</div>
                                                    @endif
                                                    <div class="mt-2">
                                                        <img src="{{ asset($etudiant->path_bac) }}" alt="BAC" class="preview-img" id="preview_path_bac">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($etablissement->show_diplome_deug_input_passerelle)   
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="path_diplomedeug">Diplome Du Bac+2</label>
                                                    <div class="custom-file-input-wrapper">
                                                        <input type="file" name="path_diplomedeug" id="path_diplomedeug" class="custom-file-input {{ $errors->has('path_diplomedeug') ? 'is-invalid' : '' }}" onchange="previewImage(this)">
                                                        <label class="custom-file-label" for="path_diplomedeug"><i class="fas fa-upload"></i> Choisir une image</label>
                                                    </div>
                                                    @if($errors->has('path_diplomedeug'))
                                                        <div class="invalid-feedback d-block">{{ $errors->first('path_diplomedeug') }}</div>
                                                    @endif
                                                    <div class="mt-2">
                                                        <img src="{{ asset($etudiant->path_diplomedeug) }}" alt="BAC+2" class="preview-img" id="preview_path_diplomedeug">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($etablissement->show_attestation_no_emploi_input_passerelle)   
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="path_attestation_non_emploi">Attestation de non-emploi</label>
                                                    <div class="custom-file-input-wrapper">
                                                        <input type="file" name="path_attestation_non_emploi" id="path_attestation_non_emploi" class="custom-file-input {{ $errors->has('path_attestation_non_emploi') ? 'is-invalid' : '' }}" onchange="previewImage(this)">
                                                        <label class="custom-file-label" for="path_attestation_non_emploi"><i class="fas fa-upload"></i> Choisir une image</label>
                                                    </div>
                                                    @if($errors->has('path_attestation_non_emploi'))
                                                        <div class="invalid-feedback d-block">{{ $errors->first('path_attestation_non_emploi') }}</div>
                                                    @endif
                                                    <div class="mt-2">
                                                        <img src="{{ asset($etudiant->path_attestation_non_emploi) }}" alt="NONEMPLOI" class="preview-img" id="preview_path_attestation_non_emploi">
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if ($etablissement->show_cv_input_passerelle)             
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="path_cv">CV (PDF)</label>
                                                    <div class="custom-file-input-wrapper">
                                                        <input type="file" name="path_cv" class="custom-file-input {{ $errors->has('path_cv') ? 'is-invalid' : '' }}" onchange="previewPDF(this)">
                                                        <label class="custom-file-label" for="path_cv"><i class="fas fa-file-pdf"></i> Choisir un fichier PDF</label>
                                                    </div>
                                                    @if($errors->has('path_cv'))
                                                        <div class="invalid-feedback d-block">{{ $errors->first('path_cv') }}</div>
                                                    @endif
                                                    <div class="mt-2">
                                                        <iframe src="{{ asset($etudiant->path_cv) }}" width="100%" height="400px" style="border:1px solid #ccc;" id="preview_path_cv"></iframe>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                                    
                                        <div class="col-lg-12">
                                            <button class="btn btn-primary btn-block">Modifier</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </form>         
                        </div>

                        <div class="tab-pane fade" id="choixFiliere" role="tabpanel" aria-labelledby="profile-tab2">
                            <form method="POST" action="{{ route('etudiant.candidatures.passerelle.choixFiliere.update', ['etudiant' => $etudiant->id]) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                        
                                <div class="card-header text-center">
                                    <h4 class="title">Modifier Mon Choix de Filière</h4>
                                </div>
                        
                                <div class="card-body">
                                    <div class="container">
                        
                                        @if($etablissement->multiple_choix_filiere_passerelle == 0)
                                            {{-- Single Choice --}}
                                            @php
                                                $selectedFiliere = old('filieres.0', $etudiant->filiere);
                                            @endphp
                        
                                            <div class="filiere-grid">
                                                @foreach($filieres as $filiere)
                                                    <label class="filiere-card">
                                                        <input 
                                                            type="radio" 
                                                            name="filieres[]" 
                                                            class="form-check-input filiere-radio" 
                                                            value="{{ $filiere->id }}"
                                                            {{ $selectedFiliere == $filiere->id ? 'checked' : '' }}>
                        
                                                        @if($selectedFiliere == $filiere->id)
                                                            <div class="badge-choix">Mon Choix</div>
                                                        @endif
                        
                                                        <div class="filiere-name">{{ $filiere->nom_abrv }}</div>
                                                        <div class="filiere-full">{{ $filiere->nom_complet }}</div>
                        
                                                        @if($filiere->document)
                                                            <a href="{{ asset($filiere->document) }}" target="_blank" class="doc-link">
                                                                📄 Voir le document
                                                            </a>
                                                        @endif
                                                    </label>
                                                @endforeach
                                            </div>
                                        @else
                                            {{-- Multiple Choice --}}
                                            @php
                                                $oldChoices = old('filieres', [
                                                    $etudiant->filiere_choix_1,
                                                    $etudiant->filiere_choix_2,
                                                    $etudiant->filiere_choix_3
                                                ]);
                        
                                                $selected = collect($oldChoices)->filter(); // remove nulls
                                            @endphp
                        
                                            <div class="filiere-grid">
                                                @foreach($filieres as $filiere)
                                                    @php
                                                        $choiceIndex = $selected->search($filiere->id);
                                                    @endphp
                                                    <label class="filiere-card">
                                                        <input 
                                                            type="checkbox" 
                                                            name="filieres[]" 
                                                            class="form-check-input filiere-checkbox" 
                                                            value="{{ $filiere->id }}"
                                                            {{ $selected->contains($filiere->id) ? 'checked' : '' }}>
                        
                                                        @if($choiceIndex !== false)
                                                            <div class="badge-choix">
                                                                {{ $choiceIndex + 1 }}{{ ['er', 'ème', 'ème'][$choiceIndex] }} Choix
                                                            </div>
                                                        @endif
                        
                                                        <div class="filiere-name">{{ $filiere->nom_abrv }}</div>
                                                        <div class="filiere-full">{{ $filiere->nom_complet }}</div>
                        
                                                        @if($filiere->document)
                                                            <a href="{{ asset($filiere->document) }}" target="_blank" class="doc-link">
                                                                📄 Voir le document
                                                            </a>
                                                        @endif
                                                    </label>
                                                @endforeach
                                            </div>
                        
                                            <!-- Hidden fields to hold the first, second, and third choices -->
                                            <input type="hidden" id="filiere_choix_1" name="filiere_choix_1" value="{{ old('filiere_choix_1', $etudiant->filiere_choix_1) }}">
                                            <input type="hidden" id="filiere_choix_2" name="filiere_choix_2" value="{{ old('filiere_choix_2', $etudiant->filiere_choix_2) }}">
                                            <input type="hidden" id="filiere_choix_3" name="filiere_choix_3" value="{{ old('filiere_choix_3', $etudiant->filiere_choix_3) }}">
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="card-footer text-center mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                        
                        
                        
                        

                  </div>
                </div>
              </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function () {
        function toggleFonctionnaireFields() {
            const isFonctionnaire = $('select[name="fonctionnaire"]').val() === '1';

            const fields = [
                'secteur',
                'nombreannee',
                'poste',
                'lieutravail',
                'villetravail'
            ];

            fields.forEach(function (field) {
                const fieldElement = $('[name="' + field + '"]').closest('.col-lg-6');

                if (isFonctionnaire) {
                    fieldElement.show();
                } else {
                    fieldElement.hide();
                    $('[name="' + field + '"]').val('');
                }
            });
        }

        // Initial toggle
        toggleFonctionnaireFields();

        // Change event
        $('select[name="fonctionnaire"]').on('change', toggleFonctionnaireFields);
    });
</script>

<!-- JavaScript Images -->
<script>
    function previewImage(input) {
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
        const maxSize = 307200; // 300 KB in bytes
        const file = input.files[0];
        const previewId = "preview_" + input.name;

        const errorDiv = createOrGetErrorDiv(input);

        if (!file) return;

        // Validate type
        if (!allowedTypes.includes(file.type)) {
            errorDiv.textContent = "Format de fichier invalide. Seuls JPEG, JPG, PNG sont autorisés.";
            clearPreview(previewId);
            return;
        }

        // Validate size
        if (file.size > maxSize) {
            errorDiv.textContent = "Taille du fichier dépassée. Maximum autorisé: 300 KB.";
            clearPreview(previewId);
            return;
        }

        // Clear any previous error
        errorDiv.textContent = "";

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = document.getElementById(previewId);
            if (img) {
                img.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }

    function previewPDF(input) {
        const maxSize = 358400; // 350 KB in bytes
        const file = input.files[0];
        const previewId = "preview_" + input.name;

        const errorDiv = createOrGetErrorDiv(input);

        if (!file) return;

        if (file.type !== "application/pdf") {
            errorDiv.textContent = "Format invalide. Seuls les fichiers PDF sont autorisés.";
            clearPreview(previewId);
            return;
        }

        if (file.size > maxSize) {
            errorDiv.textContent = "Taille du fichier dépassée. Maximum autorisé: 350 KB.";
            clearPreview(previewId);
            return;
        }

        errorDiv.textContent = "";

        const fileURL = URL.createObjectURL(file);
        const iframe = document.getElementById(previewId);
        if (iframe) {
            iframe.src = fileURL;
        }
    }

    function createOrGetErrorDiv(input) {
        let errorDiv = input.parentNode.querySelector(".js-error-message");
        if (!errorDiv) {
            errorDiv = document.createElement("div");
            errorDiv.classList.add("invalid-feedback", "d-block", "js-error-message");
            input.parentNode.appendChild(errorDiv);
        }
        return errorDiv;
    }

    function clearPreview(previewId) {
        const el = document.getElementById(previewId);
        if (el) {
            if (el.tagName === "IMG") el.src = "";
            if (el.tagName === "IFRAME") el.src = "";
        }
    }
</script>


<script>
    $(document).ready(function () {
        let selectionOrder = [];

        // Restore initial order from hidden inputs instead of DOM
        const initialChoices = [
            $('#filiere_choix_1').val(),
            $('#filiere_choix_2').val(),
            $('#filiere_choix_3').val()
        ];

        initialChoices.forEach(function (val) {
            if (val) selectionOrder.push(val);
        });

        // Function to update the hidden inputs and badges
        function updateCheckboxBadges() {
            $('.filiere-checkbox').each(function () {
                $(this).closest('.filiere-card').find('.badge-choix').remove();
            });

            // Clean up if some elements were unchecked
            selectionOrder = selectionOrder.filter(function (val) {
                return $('.filiere-checkbox[value="' + val + '"]').is(':checked');
            });

            // Render updated badges
            const labels = ['1er choix', '2e choix', '3e choix'];
            selectionOrder.forEach(function (val, i) {
                if (i < 3) {
                    $('.filiere-checkbox[value="' + val + '"]')
                        .closest('.filiere-card')
                        .append(`<div class="badge-choix">${labels[i]}</div>`);
                }
            });

            // Disable unchecked checkboxes if 3 selected
            $('.filiere-checkbox').not(':checked').prop('disabled', selectionOrder.length >= 3);

            // Update hidden inputs
            $('#filiere_choix_1').val(selectionOrder[0] || '');
            $('#filiere_choix_2').val(selectionOrder[1] || '');
            $('#filiere_choix_3').val(selectionOrder[2] || '');
        }

        // Handle checkbox changes
        $(document).on('change', '.filiere-checkbox', function () {
            const val = $(this).val();

            if ($(this).is(':checked')) {
                if (!selectionOrder.includes(val)) {
                    selectionOrder.push(val);
                }
            } else {
                selectionOrder = selectionOrder.filter(item => item !== val);
            }

            updateCheckboxBadges();
        });

        updateCheckboxBadges(); // initial update on load

        // Handle radio buttons (single choice mode)
        function updateRadioBadge() {
            $('.filiere-radio').each(function () {
                $(this).closest('.filiere-card').find('.badge-choix').remove();
            });

            let selected = $('.filiere-radio:checked');
            if (selected.length > 0) {
                selected.closest('.filiere-card').append(`<div class="badge-choix">Mon choix</div>`);
            }
        }

        $(document).on('change', '.filiere-radio', function () {
            updateRadioBadge();
        });

        updateRadioBadge(); // initialize
    });
</script>



@endsection
