@extends('sup-admin.layouts.master')

@section('content')

<style>
    body {
        background: #f4f7fa;
        font-family: 'Poppins', sans-serif;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .profile-container {
        display: flex;
        justify-content: center;
        padding: 80px 15px;
    }

    .profile-card {
        width: 100%;
        max-width: 1000px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        overflow: hidden;
        position: relative;
        transition: transform 0.3s ease;
    }

    .profile-card:hover {
        transform: translateY(-10px);
    }

    /* Status ribbon */
    .status-ribbon {
        position: absolute;
        top: 20px;
        right: -50px;
        transform: rotate(45deg);
        width: 180px;
        text-align: center;
        font-weight: 700;
        color: #fff;
        padding: 8px 0;
        font-size: 0.95rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        z-index: 999; /* ensures it's on top */
    }

    .status-en-cours { background-color: #f39c12; }
    .status-verifier { background-color: #27ae60; }
    .status-rejeter { background-color: #e74c3c; }

    /* Profile Header */
    .profile-header {
        background-color: #003366;
        color: #fff;
        padding: 60px 20px 100px 20px;
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .profile-header h2 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
    }

    /* Profile Image */
    .profile-image-container {
        position: absolute;
        bottom: -80px;
        left: 50%;
        transform: translateX(-50%);
        width: 160px;
        height: 160px;
        z-index: 10; /* on top of header */
    }

    .profile-image {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 5px 25px rgba(0,0,0,0.2);
        overflow: hidden;
        background: #fff;
    }

    .profile-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Sections */
    .section-card {
        background: #f9f9f9;
        border-left: 5px solid #003366;
        padding: 20px;
        margin: 50px 20px 20px 20px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .section-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.1);
    }

    .section-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #003366;
        margin-bottom: 15px;
        border-bottom: 2px solid #003366;
        padding-bottom: 5px;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #ddd;
    }

    .detail-item:last-child {
        border-bottom: none;
    }

    .detail-label {
        font-weight: 600;
        color: #555;
    }

    .detail-value {
        font-weight: 500;
        color: #003366;
    }

    /* Responsive */
    @media(max-width: 768px) {
        .profile-card {
            padding: 20px;
        }
        .section-card {
            margin-top: 150px;
        }
        .profile-header h2 {
            font-size: 1.6rem;
        }
        .profile-image-container {
            width: 120px;
            height: 120px;
            bottom: -60px;
        }
        .status-ribbon {
            width: 140px;
            font-size: 0.8rem;
            right: -30px;
            top: 15px;
        }
    }
</style>

<div class="main-content">
    <section class="profile-container">
        <div class="profile-card">

            {{-- Status Ribbon --}}
            <div class="status-ribbon
                {{ strtolower($etudiant->verif) == 'verifier' ? 'status-verifier' : 
                   (strtolower($etudiant->verif) == 'rejeter' ? 'status-rejeter' : 'status-en-cours') }}">
                {{ strtoupper($etudiant->verif) }}
            </div>

            {{-- Profile Header --}}
            <div class="profile-header">
                <h2>Candidature Licence (Accès S1)</h2>

                {{-- Profile Image --}}
                <div class="profile-image-container">
                    <div class="profile-image">
                        <img src="{{ asset('images/student.png') }}" alt="Photo du candidat">
                    </div>
                </div>
            </div>

            {{-- Informations personnelles --}}
            <div class="section-card">
                <div class="section-title">Informations personnelles</div>
                <div class="detail-item"><span class="detail-label">CNE:</span> <span class="detail-value">{{ $etudiant->CNE }}</span></div>
                <div class="detail-item"><span class="detail-label">CIN:</span> <span class="detail-value">{{ $etudiant->CIN }}</span></div>
                <div class="detail-item"><span class="detail-label">Nom:</span> <span class="detail-value">{{ $etudiant->nom }}</span></div>
                <div class="detail-item"><span class="detail-label">Prénom:</span> <span class="detail-value">{{ $etudiant->prenom }}</span></div>
                <div class="detail-item"><span class="detail-label">Email:</span> <span class="detail-value">{{ $etudiant->email }}</span></div>
                <div class="detail-item"><span class="detail-label">Téléphone:</span> <span class="detail-value">{{ $etudiant->phone }}</span></div>
            </div>

            {{-- Baccalauréat --}}
            <div class="section-card">
                <div class="section-title">Baccalauréat</div>
                <div class="detail-item"><span class="detail-label">Série:</span> <span class="detail-value">{{ $etudiant->serie }}</span></div>
                <div class="detail-item"><span class="detail-label">Moyenne:</span> <span class="detail-value">{{ $etudiant->moyenne_bac }}</span></div>
            </div>

            {{-- Expérience professionnelle --}}
            <div class="section-card">
                <div class="section-title">Expérience professionnelle</div>
                <div class="detail-item"><span class="detail-label">Secteur:</span> <span class="detail-value">{{ $etudiant->secteur }}</span></div>
                <div class="detail-item"><span class="detail-label">Poste:</span> <span class="detail-value">{{ $etudiant->poste }}</span></div>
            </div>

           

            {{-- Filière Licences (Accès S1) --}}
            <div class="section-card">
                <div class="section-title">Filière Licences (Accès S5)</div>
                <div class="detail-item"><span class="detail-label">Nom de la filière:</span> <span class="detail-value">{{ $etudiant->filiere_name }}</span></div>
                <div class="detail-item"><span class="detail-label">Date de candidature:</span> <span class="detail-value">{{ \Carbon\Carbon::parse($etudiant->created_at)->format('d/m/Y H:i') }}</span></div>
            </div>

        </div>
    </section>
</div>

@endsection
