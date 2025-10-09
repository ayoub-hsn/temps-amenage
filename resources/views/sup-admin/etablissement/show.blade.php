@extends('sup-admin.layouts.master')

@section('content')

<div class="main-content">
    <section class="section">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="card shadow-lg border-0">
                    <div class="card-header text-white text-center" 
                         style="background: linear-gradient(135deg, #003366, #0066cc); border-radius: 12px 12px 0 0;">
                        <h4 class="mb-0" style="color: white !important;">Détails de l'établissement</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column: Logo -->
                            <div class="col-md-4 text-center mb-4 mb-md-0">
                                <div class="logo-container" style="position: relative;">
                                    <img src="{{ asset($etablissement->logo) }}" 
                                         alt="Logo de {{ $etablissement->nom }}" 
                                         class="img-fluid rounded-circle border shadow-lg" 
                                         style="max-height: 200px; border: 6px solid rgba(102, 16, 242, 0.5); transition: transform 0.3s;">
                                </div>
                                <h5 class="mt-3 font-weight-bold text-dark">{{ $etablissement->nom_abrev }}</h5>
                            </div>

                            <!-- Right Column: Details -->
                            <div class="col-md-8">
                                <div class="detail-section mb-4">
                                    <h5 class="font-weight-bold text-dark">Nom complet :</h5>
                                    <p class="text-muted" style="font-size: 1.1rem; line-height: 1.8; color: #444; text-align: justify;">
                                        {{ $etablissement->nom }}
                                    </p>
                                </div>

                                <div class="detail-section mb-4">
                                    <h5 class="font-weight-bold text-dark">Description :</h5>
                                    <p class="text-muted" 
                                       style="font-size: 1.1rem; line-height: 1.8; color: #444; text-align: justify; text-indent: 20px;">
                                       {{ $etablissement->description }}
                                    </p>
                                </div>

                                <div class="detail-section mb-4">
                                    <h5 class="font-weight-bold text-dark">Responsable:</h5>
                                    <p class="text-muted" style="font-size: 1.1rem; line-height: 1.8; color: #444;">
                                        {{ $etablissement->responsable->name }}
                                    </p>
                                </div>

                                <div class="detail-section mb-4">
                                    <h5 class="font-weight-bold text-dark">Choix multiples pour filières :</h5>
                                    <p class="text-muted" style="font-size: 1.1rem; line-height: 1.8; color: #444;">
                                        {{ $etablissement->multiple_choix_filiere ? 'Oui' : 'Non' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-center" 
                         style="background: linear-gradient(135deg, #0066cc, #003366); border-radius: 0 0 12px 12px;">
                        <a href="{{route('sup-admin.etablissement.index')}}" class="btn btn-light text-primary font-weight-bold shadow-lg px-4 py-2" style="border-radius: 50px; font-size: 1.1rem;color:black !important;">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

<style>
    .card {
        border-radius: 20px;
        background: linear-gradient(180deg, #ffffff, #f9f9fb);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        font-size: 2rem;
        font-weight: bold;
        padding: 1.8rem;
        border-radius: 12px 12px 0 0;
        text-transform: uppercase;
    }

    .card-body {
        padding: 2.5rem;
        color: #343a40;
        background: #f5f8fa;
        border-radius: 0 0 12px 12px;
        box-shadow: inset 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .detail-section h5 {
        font-size: 1.35rem;
        color: #0066cc;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .detail-section p {
        font-size: 1.1rem;
        color: #444;
        line-height: 1.8;
        text-align: justify;
        margin-bottom: 15px;
    }

    .btn-light {
        padding: 0.8rem 2.5rem;
        font-size: 1.2rem;
        transition: all 0.3s ease;
        border-radius: 50px;
    }

    .btn-light:hover {
        background-color: #0066cc;
        color: #fff;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    img:hover {
        transform: scale(1.1);
        cursor: pointer;
    }

    .text-primary {
        color: #0066cc !important;
    }

    .text-muted {
        color: #6c757d !important;
    }

    .logo-container {
        position: relative;
        overflow: hidden;
        border-radius: 50%; /* Keeps the circular shape */
        max-height: 200px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1); /* Soft shadow for depth */
        transition: all 0.3s ease; /* Smooth transition for hover effect */
    }

    .logo-container img {
        transition: transform 0.3s ease-in-out;
        width: 100%; /* Ensures image fills container */
        height: auto;
        border-radius: 50%; /* Makes sure the image keeps the rounded shape */
        object-fit: contain;
    }

    .logo-container:hover {
        transform: scale(1.05); /* Slight zoom effect */
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2); /* A bit stronger shadow on hover */
    }

    .logo-container img:hover {
        transform: scale(1.1); /* Slightly zoom the image for emphasis */
    }

    /* Card Footer Styling */
    .card-footer {
        background: linear-gradient(135deg, #0066cc, #003366);
        border-radius: 0 0 12px 12px;
        padding: 1.2rem;
    }

    .card-footer .btn {
        font-weight: 600;
        padding: 1rem 3rem;
    }
</style>
