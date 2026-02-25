@extends('admin-etab.layouts.master')
@section('content')
@if ($etudiant->verif == "VERIFIER")

    <style>
        /* =====================================================
        SAFE OFFSET FOR FIXED NAVBAR + SIDEBAR (MASTER)
        ===================================================== */

        .page-wrapper {
            padding: 90px 25px 30px 25px; /* TOP = navbar height */
            background: linear-gradient(135deg, #f4f7fb, #eef2f7);
            min-height: 100vh;
        }

        /* Sidebar width fix (desktop only) */
        @media (min-width: 992px) {
            .page-wrapper {
                padding-left: 280px; /* sidebar width */
            }
        }

        /* =====================================================
        GRID
        ===================================================== */

        .profile-grid {
            max-width: 1400px;
            margin: auto;
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 30px;
        }

        @media (max-width: 992px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }
        }

        /* =====================================================
        CARDS
        ===================================================== */

        .glass-card {
            background: #ffffff;
            border-radius: 18px;
            box-shadow: 0 18px 40px rgba(0,0,0,.12);
            overflow: hidden;
            position: relative;
        }

        /* =====================================================
        STATUS RIBBON
        ===================================================== */

        .status-ribbon {
            position: absolute;
            top: 18px;
            right: -60px;
            transform: rotate(45deg);
            width: 220px;
            text-align: center;
            padding: 9px 0;
            font-weight: 700;
            color: #fff;
            z-index: 5;
            font-size: .9rem;
        }

        .status-verifier { background: #2ecc71; }
        .status-rejeter  { background: #e74c3c; }
        .status-en-cours { background: #f39c12; }

        /* =====================================================
        PROFILE HEADER
        ===================================================== */

        .profile-header {
            background: linear-gradient(135deg, #003366, #00509e);
            padding: 55px 20px 95px;
            color: #fff;
            text-align: center;
            position: relative;
        }

        .profile-header h2 {
            font-weight: 700;
            margin-bottom: 4px;
        }

        .profile-header p {
            font-size: .95rem;
            opacity: .9;
        }

        /* =====================================================
        AVATAR
        ===================================================== */

        .avatar {
            position: absolute;
            bottom: -65px;
            left: 50%;
            transform: translateX(-50%);
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: #fff;
            padding: 6px;
            box-shadow: 0 10px 30px rgba(0,0,0,.25);
        }

        .avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        /* =====================================================
        PROFILE BODY
        ===================================================== */

        .profile-body {
            padding: 90px 30px 30px;
        }

        .section-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: #003366;
            margin: 22px 0 12px;
            border-left: 4px solid #003366;
            padding-left: 12px;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px dashed #ddd;
            font-size: .95rem;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #555;
        }

        .info-value {
            font-weight: 600;
            color: #003366;
            text-align: right;
        }

        /* =====================================================
        FORM
        ===================================================== */

        .form-card {
            padding: 35px;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #003366;
            margin-bottom: 25px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            font-weight: 600;
            color: #555;
            margin-bottom: 6px;
        }

        .form-control {
            border-radius: 12px;
            padding: 11px 14px;
            border: 1px solid #ccc;
            transition: all .2s ease;
            font-size: .95rem;
        }

        .form-control:focus {
            border-color: #003366;
            box-shadow: 0 0 0 0.15rem rgba(0,51,102,.25);
        }

        .btn-save {
            width: 100%;
            padding: 13px;
            font-weight: 700;
            background: linear-gradient(135deg, #003366, #00509e);
            border: none;
            color: #fff;
            border-radius: 14px;
            margin-top: 10px;
            font-size: 1rem;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #002244, #003f7f);
        }
    </style>

    <div class="page-wrapper">

        <div class="profile-grid">

            {{-- ================= LEFT : STUDENT PROFILE ================= --}}
            <div class="glass-card">

                <div class="status-ribbon
                    {{ strtolower($etudiant->verif) == 'verifier' ? 'status-verifier' :
                    (strtolower($etudiant->verif) == 'rejeter' ? 'status-rejeter' : 'status-en-cours') }}">
                    {{ strtoupper($etudiant->verif) }}
                </div>

                <div class="profile-header">
                    <h2>{{ $etudiant->nom }} {{ $etudiant->prenom }}</h2>
                    <p>Candidature Master</p>

                    <div class="avatar">
                        <img src="{{ asset('images/student.png') }}">
                    </div>
                </div>

                <div class="profile-body">

                    <div class="section-title">Informations personnelles</div>
                    <div class="info-row"><span class="info-label">CNE</span><span class="info-value">{{ $etudiant->CNE }}</span></div>
                    <div class="info-row"><span class="info-label">CIN</span><span class="info-value">{{ $etudiant->CIN }}</span></div>
                    <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $etudiant->email }}</span></div>
                    <div class="info-row"><span class="info-label">Téléphone</span><span class="info-value">{{ $etudiant->phone }}</span></div>

                    <div class="section-title">Licence</div>
                    <div class="info-row"><span class="info-label">Type</span><span class="info-value">{{ $etudiant->typelicence }}</span></div>
                    <div class="info-row"><span class="info-label">Établissement</span><span class="info-value">{{ $etudiant->etblsmtLp }}</span></div>
                    <div class="info-row"><span class="info-label">Mention</span><span class="info-value">{{ $etudiant->mentionlp }}</span></div>
                    <div class="info-row"><span class="info-label">Moyenne</span><span class="info-value">{{ $etudiant->moyenne_licence }}</span></div>

                    <div class="section-title">Filière Master</div>
                    <div class="info-row"><span class="info-label">Filière</span><span class="info-value">{{ $etudiant->filiere_name }}</span></div>
                    <div class="info-row">
                        <span class="info-label">Date candidature</span>
                        <span class="info-value">
                            {{ \Carbon\Carbon::parse($etudiant->created_at)->format('d/m/Y') }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- ================= RIGHT : INSCRIPTION FORM ================= --}}
            <div class="glass-card form-card">

                <div class="form-title">Inscription administrative</div>

                <form action="{{ route('admin-etab.payment.master.filiere.student.store', ['filiere' => $etudiant->filiere, 'etudiant' => $etudiant->id]) }}"
                    method="POST"
                    enctype="multipart/form-data">

                    @csrf
                    <input type="hidden" value="{{ $etudiant->id }}" name="student_id">
                    <input type="hidden" value="{{ $etudiant->CNE }}" name="CNE">
                    <input type="hidden" value="{{ $etudiant->CIN }}" name="CIN">
                    <input type="hidden" value="{{ $etudiant->nom }}" name="nom">
                    <input type="hidden" value="{{ $etudiant->prenom }}" name="prenom">
                    <input type="hidden" value="{{ $etudiant->email }}" name="email">
                    <input type="hidden" value="{{ $etudiant->phone }}" name="phone">
                    <input type="hidden" value="{{ $etudiant->filiere }}" name="filiere">

                    <div class="form-group">
                        <label>Date d’inscription</label>
                        <input type="date" name="date_inscription" 
                            class="form-control @error('date_inscription') is-invalid @enderror" 
                            value="{{ old('date_inscription') }}">
                        @error('date_inscription')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Type de Master</label>
                        <select name="type_master" 
                                class="form-control @error('type_master') is-invalid @enderror" 
                                >
                            <option value="">-- Choisir --</option>
                            <option value="M1" {{ old('type_master') == 'M1' ? 'selected' : '' }}>M1</option>
                            <option value="M2" {{ old('type_master') == 'M2' ? 'selected' : '' }}>M2</option>
                        </select>
                        @error('type_master')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>État de paiement</label>
                        <select name="etat_payment" 
                                class="form-control @error('etat_payment') is-invalid @enderror" 
                                >
                            <option value="">-- Choisir --</option>
                            <option value="En attente" {{ old('etat_payment') == 'En attente' ? 'selected' : '' }}>En attente</option>
                            <option value="Partielle" {{ old('etat_payment') == 'Partielle' ? 'selected' : '' }}>Partielle</option>
                            <option value="Complete" {{ old('etat_payment') == 'Complete' ? 'selected' : '' }}>Complète</option>
                            <option value="Complete(Fonctionnaire à l'UH1)" {{ old('etat_payment') == "Complete(Fonctionnaire à l'UH1)" ? 'selected' : '' }}>Complète(Fonctionnaire à l'UH1)</option>
                        </select>
                        @error('etat_payment')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Montant payé (DH)</label>
                        <input type="number" step="0.01" name="montant_paye" 
                            class="form-control @error('montant_paye') is-invalid @enderror" 
                            value="{{ old('montant_paye') }}">
                        @error('montant_paye')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label>Document (image)</label>
                        <input type="file" class="filepond" name="file" id="filepond" accept="image/*" data-max-file-size="400KB" >
                        @error('file')
                            <div class="text-danger mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="btn-save">
                        Enregistrer l’inscription
                    </button>

                </form>

            </div>

        </div>
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
                labelIdle: `Déposez le motif de paiement ici`,
                labelFileProcessing: 'Traitement en cours',
                labelFileProcessingComplete: 'Traitement terminé',
                labelFileProcessingAborted: 'Traitement annulé',
                labelFileProcessingError: 'Erreur de traitement',
                labelTapToCancel: 'Appuyez pour annuler',
                labelTapToRetry: 'Appuyez pour réessayer',
                labelTapToUndo: 'Appuyez pour annuler',
                labelButtonRemoveItem: 'Supprimer',
                labelFileTypeNotAllowed: 'Type de fichier non autorisé. Seuls les fichiers pdf sont autorisés.'
                }
            );


            // pond.addFile(mainPictureUrl);
            FilePond.setOptions({
                server:{
                    url:'{{ route('admin-etab.paiement.storeMedia') }}',
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



@else

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
                    <h2>Candidature Master</h2>

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
                </div>

                {{-- Expérience professionnelle --}}
                <div class="section-card">
                    <div class="section-title">Expérience professionnelle</div>
                    <div class="detail-item"><span class="detail-label">Secteur:</span> <span class="detail-value">{{ $etudiant->secteur }}</span></div>
                    <div class="detail-item"><span class="detail-label">Poste:</span> <span class="detail-value">{{ $etudiant->poste }}</span></div>
                </div>

                {{-- Parcours Licence --}}
                <div class="section-card">
                    <div class="section-title">Parcours Licence</div>
                    <div class="detail-item"><span class="detail-label">Type de Licence:</span> <span class="detail-value">{{ $etudiant->typelicence }}</span></div>
                    <div class="detail-item"><span class="detail-label">Établissement:</span> <span class="detail-value">{{ $etudiant->etblsmtLp }}</span></div>
                    <div class="detail-item"><span class="detail-label">Spécialité:</span> <span class="detail-value">{{ $etudiant->specialitelp }}</span></div>
                    <div class="detail-item"><span class="detail-label">Date d'obtention:</span> <span class="detail-value">{{ \Carbon\Carbon::parse($etudiant->date_obtention_LP)->format('d/m/Y') }}</span></div>
                    <div class="detail-item"><span class="detail-label">Mention:</span> <span class="detail-value">{{ $etudiant->mentionlp }}</span></div>
                    <div class="detail-item"><span class="detail-label">Moyenne:</span> <span class="detail-value">{{ $etudiant->moyenne_licence }}</span></div>
                </div>

                {{-- Filière Master --}}
                <div class="section-card">
                    <div class="section-title">Filière Master</div>
                    <div class="detail-item"><span class="detail-label">Nom de la filière:</span> <span class="detail-value">{{ $etudiant->filiere_name }}</span></div>
                    <div class="detail-item"><span class="detail-label">Date de candidature:</span> <span class="detail-value">{{ \Carbon\Carbon::parse($etudiant->created_at)->format('d/m/Y H:i') }}</span></div>
                </div>

            </div>
        </section>
    </div>

    @endif
    
@endsection