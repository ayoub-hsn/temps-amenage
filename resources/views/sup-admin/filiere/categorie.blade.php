@extends('sup-admin.layouts.master')
@section('content')

<style>
    body {
        background: linear-gradient(135deg, #eef2f7, #fff);
    }

    .categorie-header {
        background: linear-gradient(90deg, #004e92, #000428);
        color: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 40px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    .background-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        padding: 30px;
        margin-bottom: 40px;
    }

    .filiere-card {
        background: #f9fbfd;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
        position: relative;
        height: 100%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-top: 5px solid #004e92;
    }

    .filiere-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(0,0,0,0.2);
    }

    .filiere-abbr {
        font-size: 1.6rem;
        font-weight: bold;
        color: #004e92;
        margin-bottom: 8px;
    }

    .filiere-name {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: #333;
    }

    .badge-status {
        position: absolute;
        top: 20px;
        right: 20px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        text-transform: uppercase;
    }

    .badge-active {
        background: #28a745;
        color: white;
    }

    .badge-inactive {
        background: #dc3545;
        color: white;
    }

    .filiere-info {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .filiere-info i {
        margin-right: 6px;
        color: #004e92;
    }

    .filiere-description {
        font-size: 0.9rem;
        color: #6c757d;
        margin-top: 14px;
        flex-grow: 1;
    }

    .btn-view, .btn-doc {
        margin-top: 12px;
        width: 100%;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-view:hover, .btn-doc:hover {
        transform: scale(1.05);
    }

    .section-title {
        font-size: 1.6rem;
        font-weight: bold;
        margin: 30px 0 25px;
        color: #004e92;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
    }

    .filiere-card.green-border {
        border-top-color: #28a745;
    }
</style>

<div class="main-content">
    <section class="section">

        {{-- Header --}}
        <div class="categorie-header">
            <h3>Catégories des Filières - Université Hassan Premier</h3>
        </div>

        <div class="container">

            {{-- Container for Filières Master --}}
            <div class="background-container">
                <h5 class="section-title">
                    <i data-feather="layers"></i> Filières Master ({{ $filieresMaster->count() }})
                </h5>

                <div class="row">
                    @forelse($filieresMaster as $filiere)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="filiere-card h-100">
                                <div class="filiere-abbr">{{ $filiere->nom_abrv }}</div>
                                <div class="filiere-name">{{ $filiere->nom_complet }}</div>

                                <span class="badge-status {{ $filiere->active == 1 ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $filiere->active == 1 ? 'Active' : 'Non active' }}
                                </span>

                                <p class="filiere-info">
                                    <i data-feather="users"></i>
                                    Étudiants postulants : <strong>{{ $filiere->students_count }}</strong>
                                </p>

                                <p class="filiere-info">
                                    <i data-feather="user"></i>
                                    Responsable : <strong>{{ $filiere->responsable ?? '-' }}</strong>
                                </p>

                                {{-- <p class="filiere-description">{{ $filiere->description }}</p> --}}

                                @if($filiere->document)
                                    <a href="{{ asset($filiere->document) }}" target="_blank" class="btn btn-outline-secondary btn-doc">
                                        <i data-feather="file-text"></i> Consulter le document
                                    </a>
                                @endif

                                <a href="{{ route('sup-admin.etablissement.filiere.master.etudiants', $filiere->id) }}" class="btn btn-outline-primary btn-view">
                                    <i data-feather="eye"></i> Voir les étudiants
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">Aucune filière Master trouvée.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Container for Licences d'Excellence --}}
            <div class="background-container">
                <h5 class="section-title text-success">
                    <i data-feather="award"></i> Licences d'Excellence ({{ $filieresPasserelle->count() }})
                </h5>

                <div class="row">
                    @forelse($filieresPasserelle as $filiere)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="filiere-card h-100 green-border">
                                <div class="filiere-abbr">{{ $filiere->nom_abrv }}</div>
                                <div class="filiere-name">{{ $filiere->nom_complet }}</div>

                                <span class="badge-status {{ $filiere->active == 1 ? 'badge-active' : 'badge-inactive' }}">
                                    {{ $filiere->active == 1 ? 'Active' : 'Non active' }}
                                </span>

                                <p class="filiere-info">
                                    <i data-feather="users"></i>
                                    Étudiants postulants : <strong>{{ $filiere->students_count }}</strong>
                                </p>

                                <p class="filiere-info">
                                    <i data-feather="user"></i>
                                    Responsable : <strong>{{ $filiere->responsable ?? '-' }}</strong>
                                </p>

                                {{-- <p class="filiere-description">{{ $filiere->description }}</p> --}}

                                @if($filiere->document)
                                    <a href="{{ asset($filiere->document) }}" target="_blank" class="btn btn-outline-secondary btn-doc">
                                        <i data-feather="file-text"></i> Consulter le document
                                    </a>
                                @endif

                                <a href="{{ route('sup-admin.etablissement.filiere.passerelle.etudiants', $filiere->id) }}" class="btn btn-outline-success btn-view">
                                    <i data-feather="eye"></i> Voir les étudiants
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">Aucune filière Licence trouvée.</div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    feather.replace();
</script>

@endsection
