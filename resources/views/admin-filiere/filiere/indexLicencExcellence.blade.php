@extends('admin-filiere.layouts.master')

@section('content')

<style>
    .filiere-card {
        border-radius: 15px;
        background: #fff;
        transition: all 0.3s ease-in-out;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .filiere-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .filiere-header {
        background: linear-gradient(45deg, #6a11cb, #2575fc);
        padding: 25px;
        color: #fff;
        text-align: center;
        position: relative;
        border-radius: 15px 15px 0 0;
    }

    .filiere-status {
        position: absolute;
        top: 10px;
        right: 10px;
    }

    .filiere-title {
        font-size: 1.9rem;
        font-weight: bold;
    }

    .filiere-full-name {
        font-size: 1.25rem;
        font-weight: 600;
        color: #fff;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 5px;
        border-radius: 5px;
    }

    .card-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .badge {
        padding: 8px 15px;
        font-size: 1rem;
    }

    .btn-info, .btn-warning, .btn-success, .btn-danger {
        font-size: 1.2rem;
        padding: 10px 20px;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .btn-info:hover, .btn-warning:hover, .btn-success:hover, .btn-danger:hover {
        transform: scale(1.05);
    }

    .btn-info {
        background-color: #17a2b8;
        border-color: #17a2b8;
    }

    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .btn-lg {
        padding: 12px 25px;
        font-size: 1.1rem;
    }

    .text-dark {
        color: #333;
    }

    .fas {
        margin-right: 0;
    }

    .d-flex {
        display: flex;
    }

    .justify-content-between {
        justify-content: space-between;
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Liste des Filières</h4>
                    </div>
                    <div class="card-body">
                        @if($filieres->isEmpty())
                            <div class="alert alert-warning text-center">
                                Aucun filière trouvé.
                            </div>
                        @else
                            <div class="row" id="filieres-container">
                                @foreach($filieres as $filiere)
                                    <div class="col-lg-4 col-md-6 mb-4" >
                                        <div class="card shadow-lg rounded-xl filiere-card">
                                            <div class="filiere-header">
                                                <h5 class="filiere-title">{{ $filiere->nom_abrv }}</h5>
                                                <div class="filiere-status">
                                                    <span class="badge badge-{{ $filiere->active ? 'success' : 'danger' }}">
                                                        {{ $filiere->active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="card-body d-flex flex-column">
                                                <div class="text-center flex-grow-1">
                                                    <h6 class="filiere-full-name text-primary mb-3">{{ $filiere->nom_complet }}</h6>
                                                    <p class="font-weight-bold mb-2">
                                                        <i class="fas fa-user-tie"></i> Responsable: 
                                                        <span class="text-dark">{{ $filiere->responsable ?? 'Non défini' }}</span>
                                                    </p>
                                                    <p class="font-weight-bold">
                                                        <i class="fas fa-user-graduate"></i> Étudiants Postulants: 
                                                        <span class="badge badge-info">{{ $filiere->students_count }}</span>
                                                    </p>
                                                </div>

                                                @if($filiere->document)
                                                    <div class="text-center mt-3">
                                                        <a href="{{ asset($filiere->document) }}" target="_blank" class="btn btn-primary btn-lg" data-toggle="tooltip" data-placement="top" title="Voir le document">
                                                            <i class="fas fa-file-alt"></i> Voir le document
                                                        </a>
                                                    </div>
                                                @endif

                                                <div class="d-flex justify-content-between mt-4">
                                                    <a href="{{ route('admin-filiere.filiere.show', $filiere->id) }}" class="btn btn-info btn-lg" data-toggle="tooltip" data-placement="top" title="Voir détails">
                                                        <i class="fas fa-eye"></i> 
                                                    </a>
                                                    <a href="{{ route('admin-filiere.filiere.licenceExcellence.etudiants.index', $filiere->id) }}" class="btn btn-light btn-lg" data-toggle="tooltip" data-placement="top" title="Étudiants Postulants">
                                                        <i class="fas fa-user-graduate"></i> 
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
