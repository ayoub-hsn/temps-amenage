@extends('etudiant.layouts.master')

@section('content')

<style>
    .filiere-card {
        width: 100%;
        max-width: 580px;
        min-height: 480px;
        border-radius: 15px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.35s ease;
        padding: 25px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        border: 1px solid rgba(255, 255, 255, 0.25);
        transform: translateY(0);
        margin: auto;
    }

    .filiere-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    }

    .etab-logo {
        height: 80px;
        margin-bottom: 15px;
        object-fit: contain;
        border-radius: 10px;
        filter: drop-shadow(0 5px 10px rgba(0, 0, 0, 0.2));
    }

    .filiere-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e3c72;
        text-align: center;
        margin-top: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
        min-height: 60px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .etab-name {
        font-size: 1.1rem;
        font-weight: 500;
        color: #666;
        text-align: center;
        margin-top: 5px;
        min-height: 30px;
    }

    .date-candidature {
        font-size: 0.9rem;
        color: #777;
        margin-top: 15px;
        text-align: center;
        font-style: italic;
    }

    .row-flex {
        display: flex;
        flex-wrap: wrap;
        gap: 30px;
        justify-content: center;
    }

    .card-wrapper {
        flex: 1 1 calc(50% - 30px);
        display: flex;
        justify-content: center;
    }

    @media(max-width: 768px) {
        .card-wrapper {
            flex: 1 1 100%;
        }
    }

    .btn-actions {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        margin-top: 20px;
    }

    .btn-group {
        display: flex;
        gap: 15px;
        justify-content: center;
    }

    .btn-custom {
        padding: 12px 25px;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        border: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.35s ease;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-view {
        background: linear-gradient(135deg, #007bff, #00c6ff);
        color: white;
    }

    .btn-edit {
        background: linear-gradient(135deg, #ff9800, #ffc107);
        color: white;
    }

    .btn-custom:hover {
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }
    /* === CONFIRMATION & DOWNLOAD BUTTONS === */
    .btn-confirm {
        background: linear-gradient(135deg, #28a745, #4cd964);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.35s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        text-transform: uppercase;
    }

    .btn-confirm:hover {
        background: linear-gradient(135deg, #34c759, #2ecc71);
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.45);
    }

    /* Download button */
    .btn-download {
        background: linear-gradient(135deg, #007bff, #00c6ff);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 12px 25px;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.35s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-transform: uppercase;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .btn-download:hover {
        background: linear-gradient(135deg, #0056b3, #007bff);
        transform: translateY(-4px) scale(1.05);
        box-shadow: 0 8px 25px rgba(0, 123, 255, 0.45);
    }

    /* Add subtle press animation */
    .btn-confirm:active, .btn-download:active {
        transform: scale(0.97);
        box-shadow: 0 4px 10px rgba(0,0,0,0.25);
    }

    /* Add small glowing animation */
    @keyframes glowPulse {
        0% { box-shadow: 0 0 5px rgba(40,167,69,0.5); }
        50% { box-shadow: 0 0 20px rgba(40,167,69,0.8); }
        100% { box-shadow: 0 0 5px rgba(40,167,69,0.5); }
    }

    .btn-confirm.glow {
        animation: glowPulse 2s infinite;
    }


    .confirmation-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: linear-gradient(135deg, #28a745, #4cd964);
        color: white;
        padding: 12px 20px;
        border-radius: 10px;
        font-size: 1rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 5px 20px rgba(40, 167, 69, 0.35);
        transition: all 0.35s ease;
        position: relative;
        overflow: hidden;
        animation: fadeIn 0.8s ease-in-out;
    }

    .confirmation-badge i {
        font-size: 1.2rem;
    }

    /* Glow effect animation */
    @keyframes glowGreen {
        0% { box-shadow: 0 0 5px rgba(40,167,69,0.3); }
        50% { box-shadow: 0 0 20px rgba(40,167,69,0.6); }
        100% { box-shadow: 0 0 5px rgba(40,167,69,0.3); }
    }

    .confirmation-badge {
        animation: glowGreen 2s infinite;
    }

    /* Hover animation (optional) */
    .confirmation-badge:hover {
        transform: translateY(-3px) scale(1.05);
        background: linear-gradient(135deg, #34c759, #2ecc71);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.5);
    }

    /* Smooth fade-in animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.8); }
        to { opacity: 1; transform: scale(1); }
    }



    .no-candidature {
        text-align: center;
        padding: 60px;
        color: #888;
        font-size: 1.2rem;
        font-style: italic;
    }

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

    @keyframes popIn {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    .type-badge.master {
        background: linear-gradient(135deg, #1e3c72, #2a5298);
    }

    .type-badge.licence {
        background: linear-gradient(135deg, #11998e, #38ef7d);
    }

    .type-badge.bachelier {
        background: linear-gradient(135deg, #8e2de2, #4a00e0);
    }

    .status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 40px; /* augmenté horizontalement pour plus de largeur */
        min-width: 180px;    /* largeur minimale pour que le texte ne soit pas compressé */
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.05rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: white;
        position: relative;
        box-shadow: 0px 6px 20px rgba(0,0,0,0.25);
        gap: 10px;
    }

    .status {
        width: 50%;
        max-width: calc(100% - 50px); /* pour laisser un petit padding par rapport aux bords */
    }

    .status-cours {
        background: linear-gradient(135deg, #f39c12, #f1c40f);
    }

    .status-verifier {
        background: linear-gradient(135deg, #27ae60, #2ecc71);
    }

    .status-rejeter {
        background: linear-gradient(135deg, #e74c3c, #c0392b);
    }

    /* ==== RESPONSIVE IMPROVEMENTS ==== */

    /* For tablet and smaller devices */
    @media (max-width: 992px) {
        .row-flex {
            gap: 20px;
        }

        .card-wrapper {
            flex: 1 1 100%;
            max-width: 100%;
        }

        .filiere-card {
            max-width: 100%;
            min-height: auto;
            padding: 20px;
        }

        .filiere-title {
            font-size: 1.3rem;
        }

        .etab-logo {
            height: 70px;
        }

        .btn-group {
            flex-direction: column;
            gap: 10px;
        }

        .btn-custom {
            width: 100%;
        }
    }

    /* For small phones */
    @media (max-width: 576px) {
        .filiere-card {
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 20px;
        }

        .type-badge {
            top: -10px;
            right: -10px;
            font-size: 0.8rem;
            padding: 8px 15px;
        }

        .etab-name {
            font-size: 1rem;
        }

        .filiere-title {
            font-size: 1.1rem;
            text-align: center;
        }

        .btn-actions {
            gap: 10px;
        }

        .btn-custom, .btn-download, .btn-confirm {
            width: 100%;
            font-size: 0.95rem;
            padding: 10px 1;
        }

        .status {
            width: 100%;
            min-width: unset;
            padding: 10px;
            font-size: 0.9rem;
        }
    }

    /* For ultra-small devices (<400px width) */
    @media (max-width: 400px) {
        .etab-logo {
            height: 60px;
        }

        .filiere-title {
            font-size: 1rem;
        }

        .btn-custom {
            font-size: 0.9rem;
            padding: 8px;
        }
    }

</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h4 class="text-black">🎓 Statut de vos candidatures</h4>
                    </div>

                    <div class="card-body">
                        <div class="row-flex">

                            {{-- MASTER --}}
                            @foreach($candidaturesMaster as $candidature)
                                <div class="card-wrapper">
                                    <div class="filiere-card">
                                        <span class="type-badge master"><i class="fas fa-graduation-cap"></i> Master</span>
                                        <div class="text-center">
                                            <img src="{{ asset($candidature->etablissement_logo) }}" class="etab-logo">
                                            <div class="etab-name">{{ $candidature->etablissement_nom }}</div>
                                        </div>

                                        <div class="filiere-title">{{ $candidature->filiere_nom }}</div>
                                        <div class="date-candidature">🕒 {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y H:i') }}</div>

                                        <div class="btn-actions mt-3">
                                            <p class="status 
                                                {{ strtolower($candidature->verif) == 'verifier' ? 'status-verifier' : 
                                                   (strtolower($candidature->verif) == 'rejeter' ? 'status-rejeter' : 'status-cours') }}">
                                                @if($candidature->verif == 'VERIFIER') ✅ Validé
                                                @elseif($candidature->verif == 'REJETER') ❌ Rejeté
                                                @else ⏳ En cours
                                                @endif
                                            </p>

                                            <div class="btn-group">
                                                <a href="{{ route('etudiant.candidatures.master.show', $candidature->candidature_id) }}" class="btn-custom btn-view">
                                                    <i class="fas fa-eye"></i> Afficher
                                                </a>
                                                @if ($candidature->confirmation_student == 0)
                                                    <a href="{{ route('etudiant.candidatures.master.edit', $candidature->candidature_id) }}" class="btn-custom btn-edit">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </a>
                                                @else
                                                    <span class="confirmation-badge">
                                                        <i class="fas fa-check-circle"></i> Confirmé
                                                    </span> 
                                                @endif
                                                

                                                @if ($candidature->confirmation_student == 0)
                                                    <form id="confirmForm-{{ $candidature->candidature_id }}" 
                                                        action="{{ route('etudiant.candidatures.master.confirmer', $candidature->candidature_id) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn-custom btn-confirm" onclick="confirmSubmission('{{ $candidature->candidature_id }}')">
                                                            ✅ Confirmer
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('etudiant.candidatures.master.telecharger', $candidature->candidature_id) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-download">
                                                            <i class="fas fa-download"></i> Télécharger Reçu
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- PASSERELLE --}}
                            @foreach($candidaturesPasserelle as $candidature)
                                <div class="card-wrapper">
                                    <div class="filiere-card">
                                        <span class="type-badge licence"><i class="fas fa-book-open"></i> Licence (Accès S5)</span>
                                        <div class="text-center">
                                            <img src="{{ asset($candidature->etablissement_logo) }}" class="etab-logo">
                                            <div class="etab-name">{{ $candidature->etablissement_nom }}</div>
                                        </div>

                                        <div class="filiere-title">{{ $candidature->filiere_nom }}</div>
                                        <div class="date-candidature">🕒 {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y H:i') }}</div>

                                        <div class="btn-actions mt-3">
                                            <p class="status 
                                                {{ strtolower($candidature->verif) == 'verifier' ? 'status-verifier' : 
                                                   (strtolower($candidature->verif) == 'rejeter' ? 'status-rejeter' : 'status-cours') }}">
                                                @if($candidature->verif == 'VERIFIER') ✅ Validé
                                                @elseif($candidature->verif == 'REJETER') ❌ Rejeté
                                                @else ⏳ En cours
                                                @endif
                                            </p>

                                            <div class="btn-group">
                                                <a href="{{ route('etudiant.candidatures.passerelle.show', $candidature->candidature_id) }}" class="btn-custom btn-view">
                                                    <i class="fas fa-eye"></i> Afficher
                                                </a>

                                                @if ($candidature->confirmation_student == 0)
                                                    <a href="{{ route('etudiant.candidatures.passerelle.edit', $candidature->candidature_id) }}" class="btn-custom btn-edit">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </a>
                                                @else
                                                    <span class="confirmation-badge">
                                                        <i class="fas fa-check-circle"></i> Confirmé
                                                    </span>
                                                @endif
                                                

                                                @if ($candidature->confirmation_student == 0)
                                                    <form id="passerelleConfirmForm-{{ $candidature->candidature_id }}" 
                                                        action="{{ route('etudiant.candidatures.passerelle.confirmer', $candidature->candidature_id) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn-custom btn-confirm" onclick="confirmPasserelleSubmission('{{ $candidature->candidature_id }}')">
                                                            ✅ Confirmer
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('etudiant.candidatures.passerelle.telecharger', $candidature->candidature_id) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-download">
                                                            <i class="fas fa-download"></i> Télécharger Reçu
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- BACHELIER --}}
                            @foreach($candidaturesBachelier as $candidature)
                                <div class="card-wrapper">
                                    <div class="filiere-card">
                                        <span class="type-badge bachelier"><i class="fas fa-user-graduate"></i> Licence (Accès S1)</span>
                                        <div class="text-center">
                                            <img src="{{ asset($candidature->etablissement_logo) }}" class="etab-logo">
                                            <div class="etab-name">{{ $candidature->etablissement_nom }}</div>
                                        </div>

                                        <div class="filiere-title">{{ $candidature->filiere_nom }}</div>
                                        <div class="date-candidature">🕒 {{ \Carbon\Carbon::parse($candidature->date_candidature)->format('d/m/Y H:i') }}</div>

                                        <div class="btn-actions mt-3">
                                            <p class="status 
                                                {{ strtolower($candidature->verif) == 'verifier' ? 'status-verifier' : 
                                                   (strtolower($candidature->verif) == 'rejeter' ? 'status-rejeter' : 'status-cours') }}">
                                                @if($candidature->verif == 'VERIFIER') ✅ Validé
                                                @elseif($candidature->verif == 'REJETER') ❌ Rejeté
                                                @else ⏳ En cours
                                                @endif
                                            </p>

                                            <div class="btn-group">
                                                <a href="{{ route('etudiant.candidatures.bachelier.show', $candidature->candidature_id) }}" class="btn-custom btn-view">
                                                    <i class="fas fa-eye"></i> Afficher
                                                </a>
                                                @if ($candidature->confirmation_student == 0)
                                                    <a href="{{ route('etudiant.candidatures.bachelier.edit', $candidature->candidature_id) }}" class="btn-custom btn-edit">
                                                        <i class="fas fa-edit"></i> Modifier
                                                    </a>
                                                @else
                                                     <span class="confirmation-badge">
                                                        <i class="fas fa-check-circle"></i> Confirmé
                                                    </span>
                                                @endif

                                                @if ($candidature->confirmation_student == 0)
                                                    <form id="bachelierConfirmForm-{{ $candidature->candidature_id }}" 
                                                        action="{{ route('etudiant.candidatures.bachelier.confirmer', $candidature->candidature_id) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn-custom btn-confirm" onclick="confirmBachelierSubmission('{{ $candidature->candidature_id }}')">
                                                            ✅ Confirmer
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('etudiant.candidatures.bachelier.telecharger', $candidature->candidature_id) }}" 
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn-download">
                                                            <i class="fas fa-download"></i> Télécharger Reçu
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                        @if($candidaturesMaster->isEmpty() && $candidaturesPasserelle->isEmpty() && $candidaturesBachelier->isEmpty())
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
                <p>Vous êtes sur le point de confirmer votre candidature au cycle Licence (Accès S5).</p>
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

    function confirmBachelierSubmission(id) {
        Swal.fire({
            title: 'Confirmer la candidature ?',
            html: `
                <p>Vous êtes sur le point de confirmer votre candidature au cycle Licence (Accès S1).</p>
                <p><strong>Attention :</strong> Après la confirmation, vous ne pourrez plus la modifier.</p>
                <p>Une fois confirmée, vous pourrez télécharger votre reçu.</p>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#007bff',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Oui, confirmer !',
            cancelButtonText: 'Annuler'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('bachelierConfirmForm-' + id).submit();
            }
        });
    }


</script>
@endsection
