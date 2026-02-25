@extends('admin-etab.layouts.master')

@section('content')

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
<style>
    /* ================= PAYMENT CARD ================= */
    .payment-card {
        background: #f9fbff;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e6edf5;
        transition: all .3s ease;
        position: relative;
    }

    .payment-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 15px 35px rgba(0,0,0,.08);
    }

    .payment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .payment-title {
        font-weight: 700;
        color: #003366;
        font-size: 1.05rem;
    }

    .payment-badge {
        padding: 6px 14px;
        border-radius: 30px;
        font-size: .75rem;
        font-weight: 700;
        letter-spacing: .5px;
    }

    .badge-complete {
        background: rgba(46, 204, 113, .15);
        color: #27ae60;
    }

    .badge-pending {
        background: rgba(243, 156, 18, .15);
        color: #e67e22;
    }

    .badge-rejected {
        background: rgba(231, 76, 60, .15);
        color: #c0392b;
    }

    .payment-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px 20px;
        font-size: .9rem;
    }

    .payment-item span:first-child {
        color: #777;
        font-weight: 600;
        display: block;
        margin-bottom: 2px;
    }

    .payment-item span:last-child {
        color: #003366;
        font-weight: 700;
    }

    .preview-btn {
        margin-top: 15px;
        display: inline-block;
        padding: 8px 16px;
        border-radius: 10px;
        background: linear-gradient(135deg, #003366, #00509e);
        color: #fff;
        font-size: .85rem;
        font-weight: 600;
        cursor: pointer;
        border: none;
    }

    .preview-btn:hover {
        background: linear-gradient(135deg, #002244, #003f7f);
    }

    /* ================= IMAGE MODAL ================= */

    .image-modal {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,.75);
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .image-modal img {
        max-width: 85%;
        max-height: 85%;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0,0,0,.4);
    }

    .image-modal.active {
        display: flex;
    }

    .badge-complete {
        background: rgba(46, 204, 113, .15);
        color: #27ae60;
    }

    .badge-pending {
        background: rgba(243, 156, 18, .15);
        color: #e67e22;
    }

    .badge-partielle {
        background: rgba(52, 152, 219, .15);
        color: #2980b9;
    }

    .badge-special {
        background: rgba(155, 89, 182, .15);
        color: #8e44ad;
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

        {{-- ================= RIGHT : PAYMENT HISTORY ================= --}}
        <div class="glass-card form-card">

            <div class="form-title">
                Historique des Paiements
            </div>

            @if($payments->count())

                @foreach($payments as $payment)

                    <div class="payment-card">

                        <div class="payment-header">
                            <div class="payment-title">
                                Paiement #{{ $loop->iteration }}
                            </div>

                            @php
                                $status = $payment->etat_payment;

                                $badgeClass = match($status) {
                                    'En attente' => 'badge-pending',
                                    'Partielle' => 'badge-partielle',
                                    'Complete' => 'badge-complete',
                                    "Complete(Fonctionnaire à l'UH1)" => 'badge-special',
                                    default => 'badge-pending'
                                };
                            @endphp

                            <div class="payment-badge {{ $badgeClass }}">
                                {{ strtoupper($status) }}
                            </div>
                        </div>

                        <div class="payment-grid">

                            <div class="payment-item">
                                <span>Date inscription</span>
                                <span>{{ \Carbon\Carbon::parse($payment->date_inscription)->format('d/m/Y') }}</span>
                            </div>

                            <div class="payment-item">
                                <span>Type Master</span>
                                <span>{{ $payment->type_master }}</span>
                            </div>

                            <div class="payment-item">
                                <span>Montant payé</span>
                                <span>{{ number_format($payment->montant_paye, 0, ',', ' ') }} MAD</span>
                            </div>

                            <div class="payment-item">
                                <span>Date d’insertion</span>
                                <span>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</span>
                            </div>

                        </div>

                        @if($payment->etat_payment !== "Complete(Fonctionnaire à l'UH1)")
                            {{-- Preview Button --}}
                            <button class="preview-btn"
                                    onclick="openImage('{{ asset($payment->document) }}')">
                                Voir le reçu
                            </button>
                        @endif

                    </div>

                @endforeach

            @else

                <div style="text-align:center; padding:40px; color:#777;">
                    Aucun paiement enregistré
                </div>

            @endif

        </div>

    </div>
    <div class="image-modal" id="imageModal" onclick="closeImage()">
    <img id="modalImage" src="">
</div>

    <script>
        function openImage(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.add('active');
        }

        function closeImage() {
            document.getElementById('imageModal').classList.remove('active');
        }
    </script>
</div>

@endsection
