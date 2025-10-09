@extends('admin-etab.layouts.master')
@section('content')
<head>

    <style>
        /* Base colors */
        :root {
            --primary-color: #004B87; /* Blue from university branding */
            --secondary-color: #F1A300; /* Gold accent for modern contrast */
            --light-color: #F4F6FC; /* Light background for clean design */
            --text-color: #333; /* Dark text for good readability */
            --success-color: #28a745; /* Green for success */
            --error-color: #dc3545; /* Red for failure (échec) */
            --hover-color: #003366; /* Darker blue for hover effects */
            --border-radius: 10px; /* Rounded corners for modern style */
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: var(--light-color);
            color: var(--text-color);
            margin: 0;
            padding: 0;
        }

        .container {
            margin-top: 50px;
            padding: 20px;
        }

        .profile-card {
            background-color: #fff;
            border-radius: var(--border-radius);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            padding: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h2 {
            font-size: 36px;
            color: var(--primary-color);
            font-weight: 700;
            margin-bottom: 10px;
            transition: color 0.3s ease;
        }

        .header h2:hover {
            color: var(--secondary-color);
        }

        .status {
            font-size: 14px;
            font-weight: bold;
        }

        .status-cours{
            color: var(--secondary-color);
        }

        .status-verifier{
            color: var(--success-color);
        }

        .status-rejeter{
            color: var(--error-color);
        }

        .profile-info {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-img img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 3px solid var(--primary-color);
            margin-right: 30px;
            transition: transform 0.3s ease;
        }

        .profile-img img:hover {
            transform: scale(1.05);
        }

        .profile-img {
            display: inline-block;
            position: relative;
            overflow: hidden;
        }

        .profile-img img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 3px solid #0066cc; /* University primary color */
            transition: transform 0.3s ease;
        }

        .profile-img img:hover {
            transform: scale(1.05);
        }

        /* Gender Badge - Initially hidden, shown on hover */
        .gender-badge {
            position: absolute;
            top: 50%;
            left: 42%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent dark background */
            color: #fff;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 1.2rem;
            font-weight: 700;
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease, visibility 0.3s ease;
        }

        /* Show the gender badge on hover */
        .profile-img:hover .gender-badge {
            opacity: 1;
            visibility: visible;
        }

        /* Masculine Gender */
        .masculine {
            background-color: #004085; /* Deep blue */
            padding: 3px;
            border-radius: 8px;
        }

        /* Feminine Gender */
        .feminine {
            background-color: #D5006B; /* Rich pink */
            padding: 3px;
            border-radius: 8px;
        }



        .details h3 {
            font-size: 28px;
            color: var(--text-color);
            font-weight: 700;
        }

        .details p {
            font-size: 16px;
            color: #555;
            margin: 5px 0;
        }

        .details .email, .details .phone {
            font-weight: bold;
            color: var(--primary-color);
        }

        .education, .filiere, .documents {
            margin-top: 30px;
        }

        .section-title h4 {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            padding-left: 20px;
        }

        .section-title h4::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            width: 4px;
            height: 30px;
            background-color: var(--primary-color);
            transform: translateY(-50%);
        }

        /* Styling for education details */
        .edu-info {
            margin-top: 15px;
        }

        .edu-item {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }

        .edu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        }

        .edu-item .degree,
        .edu-item .institution,
        .edu-item .date {
            margin-bottom: 10px;
        }

        .degree-title {
            font-size: 18px;
            font-weight: 600;
            color: var(--primary-color);
        }

        .specialization {
            font-size: 16px;
            color: #666;
        }

        .institution {
            font-size: 16px;
            font-weight: 500;
        }

        .school-name {
            font-weight: bold;
            color: var(--primary-color);
        }

        .city {
            font-style: italic;
            color: #666;
        }

        /* Modern and Premium Date Styling */
        .date-obtained {
            font-size: 15px;
            color: #fff;
            background: linear-gradient(135deg, var(--primary-color), #003366); /* Gradient with university colors */
            padding: 12px 25px;
            border-radius: 35px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-top: 12px;
            display: inline-block;
            position: relative;
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2); /* Soft shadow for modern depth */
            transition: all 0.3s ease-out;
            transform: translateY(0);
            text-align: center;
            overflow: hidden; /* Prevent text from overflowing */
        }

        /* Hover effect */
        .date-obtained:hover {
            background: linear-gradient(135deg, #003366, var(--primary-color)); /* Reverse gradient on hover */
            transform: translateY(-5px); /* Slight elevation effect */
            box-shadow: 0 12px 20px rgba(0, 0, 0, 0.3); /* Enhanced shadow on hover */
            color: #fff; /* Keep text white */
        }

        /* Adding a glowing effect */
        .date-obtained::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1); /* Subtle glow effect */
            border-radius: 35px;
            animation: glowAnimation 1.5s ease-in-out infinite;
        }

        /* Glowing animation */
        @keyframes glowAnimation {
            0% { box-shadow: 0 0 10px rgba(255, 255, 255, 0.3); }
            50% { box-shadow: 0 0 20px rgba(255, 255, 255, 0.5); }
            100% { box-shadow: 0 0 10px rgba(255, 255, 255, 0.3); }
        }

        /* Adding a cool animated underline */
        .date-obtained::before {
            content: '';
            position: absolute;
            width: 0%;
            height: 2px;
            background: #fff;
            bottom: 0;
            left: 0;
            transition: width 0.4s ease-out;
        }

        .date-obtained:hover::before {
            width: 100%; /* Underline animation */
        }

        /* Make the date stand out more on hover with a subtle scale effect */
        .date-obtained:hover {
            transform: translateY(-5px) scale(1.05); /* Slight zoom-in effect */
        }




        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .edu-info {
                padding: 10px;
            }

            .edu-item {
                padding: 15px;
            }

            .section-title h4 {
                font-size: 20px;
            }

            .date-obtained {
                font-size: 13px;
                padding: 10px 20px;
            }
        }

        /* Notes and Mentions Section */
        .notes-mentions {
            margin-top: 40px;
        }

        .section-title h4 {
            font-size: 24px;
            color: var(--primary-color);
            margin-bottom: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .notes-info {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Note Item Styling */
        .note-item {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease-in-out;
        }

        .note-item:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        /* Degree and Mention Styling */
        .degree {
            display: flex;
            flex-direction: column;
        }

        .degree-title {
            font-size: 18px;
            color: var(--primary-color);
            font-weight: 600;
        }

        .specialization {
            font-size: 16px;
            color: var(--text-color);
            font-weight: 400;
        }

        .mention {
            font-size: 14px;
            color: #fff;
            background: #28a745; /* Green background for mention */
            padding: 5px 12px;
            border-radius: 20px;
            margin-top: 10px;
        }

        /* Note Value Styling */
        .note-value {
            font-size: 16px;
            color: var(--text-color);
            font-weight: bold;
            background-color: #e5e5e5;
            padding: 8px 12px;
            border-radius: 8px;
            margin-right: 10px;
            transition: background-color 0.3s ease-in-out;
        }

        .note-value:hover {
            background-color: var(--primary-color);
            color: #fff;
        }

        /* Responsive Design for Smaller Screens */
        @media (max-width: 768px) {
            .note-item {
                flex-direction: column;
                gap: 15px;
            }

            .degree-title, .specialization, .mention, .note-value {
                font-size: 14px;
            }

            .note-value {
                margin-right: 0;
            }
        }


        .education, .filiere {
            padding: 15px;
            background-color: #f7f7f7;
            border-radius: var(--border-radius);
            transition: background-color 0.3s ease;
        }

        .education:hover, .filiere:hover {
            background-color: #e9ecef;
        }

        /* Additional Styling for responsiveness */
        @media (max-width: 768px) {
            .profile-info {
                flex-direction: column;
                align-items: flex-start;
            }

            .profile-img img {
                margin-bottom: 15px;
            }

            .container {
                padding: 15px;
            }

            .header h2 {
                font-size: 28px;
            }
        }

        
        /* Image and PDF preview styles */
        .preview-container {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .preview-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two items per row */
            gap: 15px;
            justify-content: center;
        }

        /* Preview Item */
        .preview-item {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%; /* Makes sure the width is respected */
        }

        /* Image Styles */
        .preview-item img {
            width: 100%;
            max-height: 250px; /* Ensures a max height while keeping aspect ratio */
            object-fit: contain; /* Displays the whole image without cropping */
            display: block;
            align-self: stretch; /* Helps maintain correct width */
        }

        /* Special case for single wide item */
        .preview-item[style*="width: 555px;"] {
            width: 555px; /* Keeps the specified width */
        }

        /* PDF Styles */
        .preview-item iframe {
            width: 100%;
            height: 592px;
            object-fit: contain;
        }

        .pdf-full {
            max-width: 100%;
        }

        /* Hover Effect */
        .preview-item:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        /* Link/Button Styling */
        .preview-item a {
            display: block;
            position: absolute;
            bottom: 10px;
            left: 10px;
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            padding: 5px 10px;
            border-radius: var(--border-radius);
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .preview-item a:hover {
            background-color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .preview-row {
                grid-template-columns: 1fr; /* One item per row on small screens */
            }

            .preview-item {
                max-width: 100%;
            }
        }


    </style>

</head>
<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                
                    
                    <div class="row">
                        <!-- Left section for Profile Information -->
                        <div class="col-md-6">
                            <div class="profile-card">
                                <div class="header">
                                    <h2>Profile</h2>
                                    <p class="status {{ match ($etudiant->verif) {
                                        'EN COURS' => 'status-cours',
                                        'VERIFIER' => 'status-verifier',
                                        'REJETER' => 'status-rejeter',
                                        default => ''
                                    } }}">
                                        {{ $etudiant->verif }}
                                    </p>
                                </div>
                                <div class="profile-info">
                                    <div class="profile-img position-relative">
                                        <img src="{{ $etudiant->path_photo ? asset($etudiant->path_photo) : asset('images/student.png') }}" alt="Profile Picture">
                                        
                                        <!-- Gender Badge (hidden by default, shown on hover) -->
                                        <div class="gender-badge">
                                            <span class="{{ $etudiant->sexe == 'M' ? 'masculine' : 'feminine' }}">
                                                {{ $etudiant->sexe == 'M' ? 'Homme' : 'Femme' }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <h3>{{ $etudiant->nom }} {{ $etudiant->prenom }} | {{ $etudiant->nomar }} {{ $etudiant->prenomar }}</h3>
                                        <p class="email">{{ $etudiant->email }}</p>
                                        <p class="phone">{{ $etudiant->phone }}</p>
                                        <p class="birth">{{ $etudiant->datenais }} ({{ $etudiant->villenais }} - {{ $etudiant->villechamp }})</p>
                                        <p class="address">{{ $etudiant->adresse }}</p>
                                    </div>
                                </div>
                                
                            
            
                                <div class="education">
                                    <div class="section-title">
                                        <h4>Education</h4>
                                    </div>
                                    <div class="edu-info">
                                        <div class="edu-item">
                                            <div class="degree">
                                                <span class="degree-title">Baccalauréat</span>
                                                <span class="specialization">{{ $etudiant->serie }}</span>
                                            </div>
                                            <div class="date">
                                                <span class="date-obtained">{{ $etudiant->Anneebac }}</span>
                                            </div>
                                        </div>
                                        <div class="edu-item">
                                            <div class="degree">
                                                <span class="degree-title">{{$etudiant->type_diplome_obtenu}}({{ $etudiant->dernier_diplome_obtenu }})</span>
                                                <span class="specialization">{{ $etudiant->specialitediplome }}</span>
                                            </div>
                                            <div class="institution">
                                                <span class="school-name">{{ $etudiant->ville_etablissement_diplome }}</span>
                                                {{-- <span class="city">{{ $etudiant->ville_etablissement_diplome }}</span> --}}
                                            </div>
                                            <div class="date">
                                                <span class="date-obtained">{{ $etudiant->date_optention_diplome }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                {{-- Informations professionnelles --}}
                                @if ($etudiant->fonctionnaire == 1)
                                {{-- Bloc pour fonctionnaire --}}
                                <div class="job-info">
                                    <div class="section-title">
                                        <h4>Informations Professionnelles</h4>
                                    </div>
                                    <div class="job-cards">
                                        <div class="job-card">
                                            <span class="label">Secteur :</span>
                                            <span class="value">{{ $etudiant->secteur }}</span>
                                        </div>
                                        <div class="job-card">
                                            <span class="label">Poste :</span>
                                            <span class="value">{{ $etudiant->poste }}</span>
                                        </div>
                                        <div class="job-card">
                                            <span class="label">Lieu de travail :</span>
                                            <span class="value">{{ $etudiant->lieutravail }}</span>
                                        </div>
                                        <div class="job-card">
                                            <span class="label">Ville de travail :</span>
                                            <span class="value">{{ $etudiant->villetravail }}</span>
                                        </div>
                                        <div class="job-card">
                                            <span class="label">Nombre d'années :</span>
                                            <span class="value">{{ $etudiant->nombreannee }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- Bloc pour non-fonctionnaire --}}
                                <div class="student-info-card">
                                    <div class="student-info-icon">🎓</div>
                                    <div class="student-info-text">
                                        <h4>Informations d’Inscription</h4>
                                        <p>{{ $etudiant->nom }} n’est pas déclaré comme fonctionnaire lors de son inscription.</p>
                                    </div>
                                </div>
                            @endif

                                
                                
            
                                <div class="filiere">
                                    <div class="section-title">
                                        <h4>Filiere</h4>
                                    </div>
                                    @if ($etablissement->multiple_choix_filiere_passerelle == 1)
                                        <p><b>Choix 1 : </b>{{ $etudiant->filiere_choix_1_name }}</p>
                                        <p><b>Choix 2 : </b>{{ $etudiant->filiere_choix_2_name }}</p>
                                        <p><b>Choix 3 : </b>{{ $etudiant->filiere_choix_3_name }}</p>
                                    @else
                                        <p>{{ $etudiant->filiere_name }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
            
                        <!-- Right section for Documents -->
                        <div class="col-md-6">
                            <div class="profile-card">
                                <div class="header">
                                    <h2>Documents</h2>
                                    <p class="status {{ match ($etudiant->verif) {
                                        'EN COURS' => 'status-cours',
                                        'VERIFIER' => 'status-verifier',
                                        'REJETER' => 'status-rejeter',
                                        default => ''
                                    } }}">
                                        {{ $etudiant->verif }}
                                    </p>
                                </div>
                                <div class="documents">
                                    <div class="section-title">
                                        <h4>Documents</h4>
                                    </div>
                                    <div class="preview-container">
                                        <!-- Images displayed in pairs -->
                                        @if ($etablissement->show_cin_input_passerelle)
                                            <div class="preview-row">
                                                <div class="preview-item" style="width: 710px;">
                                                    <img src="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_cin))]) }}" alt="CIN">
                                                    <a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_cin))]) }}" target="_blank">CIN</a>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($etablissement->show_bac_input_passerelle)
                                            <div class="preview-row">
                                                <div class="preview-item" style="width: 710px;">
                                                    <img src="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_bac))]) }}" alt="Diplome Baccalauréat">
                                                    <a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_bac))]) }}" target="_blank">Diplome Baccalauréat</a>
                                                </div>
                                            </div>
                                        @endif

                                        @if ($etablissement->show_diplome_deug_input_passerelle)
                                            <div class="preview-row">
                                                <div class="preview-item" style="width: 710px;">
                                                    <img src="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_diplomedeug))]) }}" alt="Diplome Bac+2">
                                                    <a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_diplomedeug))]) }}" target="_blank">Diplome Bac+2</a>
                                                </div>
                                            </div>
                                        @endif


                                        @if ($etablissement->show_attestation_no_emploi_input_passerelle)
                                            <div class="preview-row">
                                                <div class="preview-item" style="width: 710px;">
                                                    <img src="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_attestation_non_emploi))]) }}" alt="Diplome Non Emploi">
                                                    <a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_attestation_non_emploi))]) }}" target="_blank">Attestation Non-Emploi</a>
                                                </div>
                                            </div>
                                        @endif
                                        

                                        <!-- PDF takes full width -->
                                        @if ($etablissement->show_cv_input_passerelle)
                                            <div class="preview-item pdf-full">
                                                <iframe src="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_cv))]) }}" width="100%" height="500px" style="border: none;"></iframe>
                                                <a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_cv))]) }}" target="_blank">CV</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                
            </div>
        </div>
    </section>
</div>


@endsection