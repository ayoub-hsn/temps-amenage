@extends('etudiant.layouts.master')

@section('content')

<style>
    /* Card Styling with soft curves and subtle shadow */
    .filiere-card {
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transform: translateY(0);
    }

    .filiere-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    /* Image styling with a rounded effect and shadow */
    .etab-logo {
        height: 80px;
        margin-bottom: 15px;
        object-fit: contain;
        border-radius: 10px;
        filter: drop-shadow(0 5px 10px rgba(0, 0, 0, 0.2));
    }

    /* Title with elegant font and spacing */
    .filiere-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #283e75;
        text-align: center;
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Establishment name with a soft color tone */
    .etab-name {
        font-size: 1.1rem;
        font-weight: 500;
        color: #666;
        text-align: center;
        margin-top: 5px;
    }

    /* Date with small but readable font */
    .date-candidature {
        font-size: 0.9rem;
        color: #777;
        margin-top: 15px;
        text-align: center;
        font-style: italic;
    }

    /* Filieres List styling with modern layout */
    .multiple-filiere-list {
        list-style: none;
        padding-left: 0;
        margin: 20px 0;
        text-align: center;
        font-weight: 600;
        color: #444;
    }

    .multiple-filiere-list li {
        padding: 7px 0;
        font-size: 1.05rem;
    }

    /* Flexbox layout for the cards */
    .row-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: space-around;
    }

    .card-wrapper {
        flex: 1 1 calc(33.333% - 30px);
        display: flex;
        margin-bottom: 30px;
    }

    /* Responsive design for smaller screens */
    @media(max-width: 992px) {
        .card-wrapper {
            flex: 1 1 calc(50% - 30px);
        }
    }

    @media(max-width: 576px) {
        .card-wrapper {
            flex: 1 1 100%;
        }
    }

    /* Action Buttons with clean styles */
    .btn-actions {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 15px;
        margin-top: auto;
    }

    .btn-custom {
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        display: inline-block;
        transition: all 0.4s ease-in-out;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-view {
        background: #2980b9;
        color: white;
    }

    .btn-edit {
        background: #f39c12;
        color: white;
    }

    .btn-confirm {
        background: #2ecc71;
        color: white;
    }

    .btn-custom:hover {
        transform: translateY(-5px);
        filter: brightness(1.1);
    }

    /* Header title with a clean, modern font */
    .card-header h4 {
        font-weight: 700;
        color: #283e75;
        font-size: 1.6rem;
        letter-spacing: 1px;
    }

    /* Empty state styling */
    .no-candidature {
        text-align: center;
        padding: 60px;
        color: #888;
        font-size: 1.2rem;
        font-style: italic;
    }

    .badge {
        display: inline-block;
        padding: 0.25em 0.5em;
        font-size: 0.75rem;
        font-weight: 600;
        color: white;
        background-color: #007bff;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
    }

    .btn-custom.btn-confirm {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 18px;
        font-size: 16px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: background 0.3s ease;
    }

    .btn-custom.btn-confirm:hover {
        background-color: #218838;
    }

    .confirmation-badge {
        background-color: #4CAF50; /* Couleur de fond verte */
        color: white; /* Texte en blanc */
        font-weight: bold; /* Texte en gras */
        padding: 5px 15px; /* Espacement autour du texte */
        border-radius: 25px; /* Coins arrondis */
        display: inline-flex; /* Pour aligner le texte et l'icône */
        align-items: center; /* Aligne le texte avec l'icône */
        font-size: 16px; /* Taille du texte */
        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); /* Ombre douce autour du badge */
    }

    .confirmation-badge i {
        margin-right: 8px; /* Espacement entre l'icône et le texte */
        font-size: 18px; /* Taille de l'icône */
    }

    /* Style for the button */
    .btn-download {
        background-color: #007bff; /* Blue background */
        color: white; /* White text */
        font-weight: bold; /* Bold text */
        padding: 12px 25px; /* Padding around the text */
        border-radius: 15px; /* Rounded corners */
        border: none; /* No border */
        font-size: 16px; /* Font size */
        display: inline-flex; /* Align text and icon inline */
        align-items: center; /* Center the text and icon vertically */
        cursor: pointer; /* Cursor change on hover */
        transition: all 0.3s ease-in-out; /* Smooth transition */
        box-shadow: 0px 5px 15px rgba(0, 123, 255, 0.2); /* Light shadow */
    }

    /* Hover effect */
    .btn-download:hover {
        background-color: #0056b3; /* Darker blue on hover */
        transform: scale(1.05); /* Slightly grow the button */
        box-shadow: 0px 10px 20px rgba(0, 123, 255, 0.3); /* Stronger shadow */
    }

    /* Icon styling */
    .btn-download i {
        margin-right: 8px; /* Space between the icon and text */
        font-size: 18px; /* Icon size */
    }

    /* Focus style for accessibility */
    .btn-download:focus {
        outline: none; /* Remove default focus outline */
        box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5); /* Blue glow when focused */
    }

/* Badge design amélioré */
.type-badge {
    position: absolute;
    top: -12px;
    right: -12px;
    padding: 10px 20px;
    border-radius: 50px;
    font-size: 0.95rem;
    font-weight: 700;
    color: white;
    text-transform: uppercase;
    letter-spacing: 1px;
    box-shadow: 0px 6px 15px rgba(0,0,0,0.2);
    z-index: 20;
    display: flex;
    align-items: center;
    gap: 6px;
    animation: popIn 0.5s ease-out;
}

/* Animation d'apparition */
@keyframes popIn {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}

/* Couleurs premium */
.type-badge.master {
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    border: 2px solid rgba(255,255,255,0.4);
}

.type-badge.licence {
    background: linear-gradient(135deg, #11998e, #38ef7d);
    border: 2px solid rgba(255,255,255,0.4);
}

/* Icône stylée */
.type-badge i {
    font-size: 1.2rem;
}



/* Style général des statuts */
/* Statut container moderne */
.status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 14px 28px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.05rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0px 6px 20px rgba(0,0,0,0.25);
    gap: 10px;
    animation: fadeInUp 0.6s ease-out;
}

/* Animation d’apparition */
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(15px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Effet glow animé */
.status::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: rgba(255,255,255,0.15);
    transform: rotate(25deg);
    animation: shine 3s infinite linear;
}
@keyframes shine {
    0% { transform: translateX(-100%) rotate(25deg); }
    100% { transform: translateX(100%) rotate(25deg); }
}

/* Couleurs premium */
.status-cours {
    background: linear-gradient(135deg, #f39c12, #f1c40f);
}

.status-verifier {
    background: linear-gradient(135deg, #27ae60, #2ecc71);
}

.status-rejeter {
    background: linear-gradient(135deg, #e74c3c, #c0392b);
}

/* Icônes */
.status i {
    font-size: 1.3rem;
    animation: bounceIcon 1.5s infinite;
}

/* Icône rebond */
@keyframes bounceIcon {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.2); }
}


</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h4 class="text-black">🎓 Status de votre candidature</h4>
                    </div>
                    <div class="card-body">
                        <div class="row-flex">
                            @foreach($candidaturesMaster as $candidature)
                                <div class="card-wrapper">
                                    <div class="filiere-card">
                                        <span class="type-badge master">
                                            <i class="fas fa-graduation-cap"></i> Master
                                        </span>
                                        <div class="text-center">
                                            <img src="{{ asset($candidature->etablissement_logo) }}" alt="Logo" class="etab-logo">
                                            <div class="etab-name">{{ $candidature->etablissement_nom }}</div>
                                        </div>

                                        @if($candidature->multiple_choix_filiere_master == 0)
                                            <div class="filiere-title">{{ $candidature->filiere_nom }}</div>
                                        @else
                                            @php
                                                $choixArray = [
                                                    'Premier Choix' => $candidature->filiere_choix_1,
                                                    'Deuxième Choix' => $candidature->filiere_choix_2,
                                                    'Troisième Choix' => $candidature->filiere_choix_3
                                                ];

                                                $label = null;
                                                foreach ($choixArray as $key => $choixId) {
                                                    if ($choixId == $candidature->filiere_id) {
                                                        $label = $key;
                                                        break;
                                                    }
                                                }

                                                $filiere = $filieres->firstWhere('id', $candidature->filiere_id);
                                            @endphp

                                            @if($filiere && $label)
                                                <ul class="multiple-filiere-list">
                                                    <li>
                                                        <span class="badge badge-primary">{{ $label }}</span>
                                                        {{ $filiere->nom_complet }}
                                                    </li>
                                                </ul>
                                            @endif
                                        @endif



                                        <div class="date-candidature">
                                            🕒 Candidature le {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y H:i') }}
                                        </div>

                                        <div class="btn-actions mt-3">
                                            <p class="status {{ match ($candidature->verif) {
                                                'EN COURS' => 'status-cours',
                                                'VERIFIER' => 'status-verifier',
                                                'REJETER' => 'status-rejeter',
                                                default => ''
                                            } }}">
                                                @switch($candidature->verif)
                                                    @case('EN COURS')
                                                        <i class="fas fa-hourglass-half"></i> En cours de traitement
                                                        @break
                                                    @case('VERIFIER')
                                                        <i class="fas fa-check-circle"></i> Validé
                                                        @break
                                                    @case('REJETER')
                                                        <i class="fas fa-times-circle"></i> Rejeté
                                                        @break
                                                    @default
                                                        <i class="fas fa-info-circle"></i> Statut inconnu
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            @foreach($candidaturesPasserelle as $candidature)
                                <div class="card-wrapper">
                                    <div class="filiere-card">
                                        <span class="type-badge licence">
                                            <i class="fas fa-book-open"></i> Licence
                                        </span>
                                        <div class="text-center">
                                            <img src="{{ asset($candidature->etablissement_logo) }}" alt="Logo" class="etab-logo">
                                            <div class="etab-name">{{ $candidature->etablissement_nom }}</div>
                                        </div>

                                        @if($candidature->multiple_choix_filiere_passerelle == 0)
                                            <div class="filiere-title">{{ $candidature->filiere_nom }}</div>
                                        @else
                                            @php
                                                $choixArray = [
                                                    'Premier Choix' => $candidature->filiere_choix_1,
                                                    'Deuxième Choix' => $candidature->filiere_choix_2,
                                                    'Troisième Choix' => $candidature->filiere_choix_3
                                                ];

                                                $label = null;
                                                foreach ($choixArray as $key => $choixId) {
                                                    if ($choixId == $candidature->filiere_id) {
                                                        $label = $key;
                                                        break;
                                                    }
                                                }

                                                $filiere = $filieres->firstWhere('id', $candidature->filiere_id);
                                            @endphp

                                            @if($filiere && $label)
                                                <ul class="multiple-filiere-list">
                                                    <li>
                                                        <span class="badge badge-primary">{{ $label }}</span>
                                                        {{ $filiere->nom_complet }}
                                                    </li>
                                                </ul>
                                            @endif
                                        @endif

                                        <div class="date-candidature">
                                            🕒 Candidature le {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y H:i') }}
                                        </div>

                                        <div class="btn-actions mt-3">
                                            <p class="status {{ match ($candidature->verif) {
                                                'EN COURS' => 'status-cours',
                                                'VERIFIER' => 'status-verifier',
                                                'REJETER' => 'status-rejeter',
                                                default => ''
                                            } }}">
                                                @switch($candidature->verif)
                                                    @case('EN COURS')
                                                        <i class="fas fa-hourglass-half"></i> En cours de traitement
                                                        @break
                                                    @case('VERIFIER')
                                                        <i class="fas fa-check-circle"></i> Validé
                                                        @break
                                                    @case('REJETER')
                                                        <i class="fas fa-times-circle"></i> Rejeté
                                                        @break
                                                    @default
                                                        <i class="fas fa-info-circle"></i> Statut inconnu
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>


                        @if($candidaturesMaster->isEmpty() && $candidaturesPasserelle->isEmpty())
                            <div class="no-candidature">Aucune candidature trouvée pour le moment.</div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
<script>
    function confirmSubmission(id) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            html: `
                <p>Vous êtes sur le point de confirmer votre candidature.</p>
                <p><strong>Attention :</strong> Si vous confirmez, vous ne pourrez plus modifier votre candidature.</p>
                <p>Après la confirmation, vous pourrez télécharger votre reçu.</p>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, confirmer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                // Soumettre le formulaire après confirmation
                document.getElementById('confirmForm-' + id).submit();
            }
        });
    }

    function confirmPasserelleSubmission(id) {
    Swal.fire({
        title: 'Confirmer la candidature ?',
        html: `
            <p>Vous êtes sur le point de confirmer votre candidature.</p>
            <p><strong>Attention :</strong> Après la confirmation, vous ne pourrez plus la modifier.</p>
            <p>Une fois confirmée, vous pourrez télécharger votre reçu.</p>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#dc3545',
        confirmButtonText: 'Oui, confirmer !',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('passerelleConfirmForm-' + id).submit();
        }
    });
}

</script>


@endsection
