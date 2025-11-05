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
                                    
                                        {{-- <div class="col-lg-6">
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
                                        </div> --}}
                                    
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


                                            <!-- Bac+2 Information -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="diplomedeug">Diplome Bac+2</label>
                                                    <select name="diplomedeug" class="form-control {{ $errors->has('diplomedeug') ? 'is-invalid' : '' }}">
                                                        @foreach ($etablissement->diplomebacplus2 as $diplome)
                                                            <option value="{{ $diplome->nom }}" {{ old('diplomedeug',$etudiant->diplomedeug) == $diplome->nom ? 'selected' : '' }}>{{ $diplome->nom }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('diplomedeug'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('diplomedeug') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                            <!-- Mention Bac+2 -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="mentiondeug">Mention Bac+2</label>
                                                    <select name="mentiondeug" class="form-control {{ $errors->has('mentiondeug') ? 'is-invalid' : '' }}">
                                                        <option value="PASSABLE" {{ old('mentiondeug',$etudiant->mentiondeug) == 'PASSABLE' ? 'selected' : '' }}>PASSABLE</option>
                                                        <option value="ASSEZ BIEN" {{ old('mentiondeug',$etudiant->mentiondeug) == 'ASSEZ BIEN' ? 'selected' : '' }}>ASSEZ BIEN</option>
                                                        <option value="BIEN" {{ old('mentiondeug',$etudiant->mentiondeug) == 'BIEN' ? 'selected' : '' }}>BIEN</option>
                                                        <option value="TRES BIEN" {{ old('mentiondeug',$etudiant->mentiondeug) == 'TRES BIEN' ? 'selected' : '' }}>TRES BIEN</option>
                                                    </select>
                                                    @if($errors->has('mentiondeug'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('mentiondeug') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                            <!-- Spécialité du Diplome Bac+2 -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="specialitedeug">Spécialité du Diplome Bac+2</label>
                                                    <input type="text" name="specialitedeug" value="{{ old('specialitedeug',$etudiant->specialitedeug) }}" class="form-control {{ $errors->has('specialitedeug') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('specialitedeug'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('specialitedeug') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        
                                            <!-- Etablissement Bac+2 -->
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
                                            </div>
                                        
                                            <!-- Date d'obtention de Bac+2 -->
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="date_obtention_deug">Date d'obtention de Bac+2</label>
                                                    <input type="date" name="date_obtention_deug" value="{{ old('date_obtention_deug',$etudiant->date_obtention_deug) }}" class="form-control {{ $errors->has('date_obtention_deug') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('date_obtention_deug'))
                                                        <div class="invalid-feedback">
                                                            {{ $errors->first('date_obtention_deug') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="moyenne_deug">Moyenne du Diplome</label>
                                                    <input type="number" step="0.01" name="moyenne_deug" value="{{ old('moyenne_deug', $etudiant->moyenne_deug) }}" class="form-control {{ $errors->has('moyenne_deug') ? 'is-invalid' : '' }}">
                                                    @if($errors->has('moyenne_deug'))
                                                        <div class="invalid-feedback">{{ $errors->first('moyenne_deug') }}</div>
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
