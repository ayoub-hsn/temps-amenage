@extends('sup-admin.layouts.master')
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
    <style>

            /* ===== MODAL BACKGROUND ===== */

            .image-modal{
                display:none;
                position:fixed;
                inset:0;
                background:rgba(0,0,0,.45);
                backdrop-filter:blur(4px);
                justify-content:center;
                align-items:center;
                z-index:9999;
            }

            .image-modal.active{
                display:flex;
            }

            /* ===== MODAL BOX ===== */

            .receipt-modal-box{
                width:90%;
                max-width:1150px;
                height:75vh;
                background:white;
                border-radius:18px;
                overflow:hidden;
                display:flex;
                flex-direction:column;

                box-shadow:
                    0 25px 70px rgba(0,0,0,.25);

                animation:modalEnter .35s ease;
            }

            @keyframes modalEnter{
                from{
                    transform:translateY(40px) scale(.95);
                    opacity:0;
                }
                to{
                    transform:translateY(0) scale(1);
                    opacity:1;
                }
            }

            /* ===== HEADER ===== */

            .receipt-modal-header{

                background:linear-gradient(
                    135deg,
                    #003366,
                    #0056b3,
                    #007bff
                );

                color:white;
                padding:18px 25px;

                display:flex;
                justify-content:space-between;
                align-items:center;
            }

            .receipt-modal-header h3{
                font-weight:600;
                letter-spacing:.3px;
            }

            /* close button */

            .close-modal{
                background:rgba(255,255,255,.2);
                border:none;
                width:34px;
                height:34px;
                border-radius:8px;
                color:white;
                font-size:16px;
                cursor:pointer;
                transition:.25s;
            }

            .close-modal:hover{
                background:white;
                color:#003366;
            }

            /* ===== BODY ===== */

            .receipt-modal-body{
                flex:1;
                display:grid;
                grid-template-columns:1.2fr .8fr;
            }

            /* ===== RECEIPT IMAGE ===== */

            .receipt-image-container{
                display:flex;
                justify-content:center;
                align-items:center;
                padding:35px;
                background:#f5f9ff;
            }

            .receipt-image-container img{
                max-width:100%;
                max-height:100%;
                border-radius:12px;

                box-shadow:
                    0 20px 50px rgba(0,0,0,.25);
            }

            /* ===== INFO PANEL ===== */

            .receipt-info{
                padding:30px;
                background:white;
                border-left:1px solid #e6eef7;
            }

            .receipt-info h4{
                font-weight:700;
                color:#003366;
                margin-bottom:25px;
            }

            /* rows */

            .receipt-info-row{
                display:flex;
                justify-content:space-between;
                align-items:center;
                padding:14px 0;
                border-bottom:1px dashed #e2e8f0;
                font-size:15px;
            }

            .receipt-info-row span:first-child{
                color:#64748b;
            }

            .receipt-info-row span:last-child{
                font-weight:600;
            }

            /* ===== STATUS BADGES ===== */

            .ocr-valid{
                background:#16a34a;
                color:white !important;
                padding:6px 14px;
                border-radius:20px;
            }

            .ocr-progress{
                background:#f59e0b;
                color:white !important;
                padding:6px 14px;
                border-radius:20px;
            }

            .ocr-manual{
                background:#ef4444;
                color:white !important;
                padding:6px 14px;
                border-radius:20px;
            }
    </style>
    <style>
    /* ================= MANUAL VERIFICATION PANEL ================= */

        .manual-verif-card{

            margin-top:30px;
            padding:26px;

            border-radius:16px;

            background:linear-gradient(
                135deg,
                #fff,
                #f9fbff
            );

            border:1px solid #e6edf5;

            position:relative;

            box-shadow:
                0 15px 40px rgba(0,0,0,.08);

            overflow:hidden;

            transition:.3s;
        }

        /* LEFT HIGHLIGHT BAR */

        .manual-verif-card::before{
            content:"";
            position:absolute;
            left:0;
            top:0;
            bottom:0;
            width:6px;

            background:linear-gradient(
                180deg,
                #ff4d4f,
                #ff7a45
            );
        }

        /* HEADER */

        .manual-verif-header{
            display:flex;
            align-items:center;
            gap:12px;
            margin-bottom:10px;
        }

        .manual-verif-header i{

            width:38px;
            height:38px;

            display:flex;
            align-items:center;
            justify-content:center;

            border-radius:10px;

            background:linear-gradient(
                135deg,
                #ff4d4f,
                #ff7a45
            );

            color:white;
            font-size:16px;

            box-shadow:
                0 8px 20px rgba(255,77,79,.35);
        }

        .manual-verif-header h4{
            font-size:1.05rem;
            font-weight:700;
            color:#b91c1c;
        }

        /* DESCRIPTION */

        .manual-verif-card p{
            font-size:.88rem;
            color:#64748b;
            margin-bottom:18px;
        }

        /* INPUT GROUP */

        .manual-input-wrapper{
            position:relative;
        }

        .manual-input-wrapper span{

            position:absolute;
            left:12px;
            top:50%;
            transform:translateY(-50%);

            font-weight:700;
            color:#94a3b8;
        }

        /* INPUT */

        .manual-verif-card input{

            width:100%;
            padding:12px 14px 12px 45px;

            border-radius:10px;
            border:1px solid #dbe2ea;

            font-weight:600;

            transition:.25s;
        }

        .manual-verif-card input:focus{

            border-color:#ff4d4f;

            box-shadow:
                0 0 0 3px rgba(255,77,79,.15);

            outline:none;
        }

        /* ACTION BUTTON */

        .manual-verif-card .btn-save{

            margin-top:15px;

            width:100%;
            padding:12px;

            border:none;

            border-radius:12px;

            font-weight:700;
            letter-spacing:.3px;

            background:linear-gradient(
                135deg,
                #ff4d4f,
                #d9363e
            );

            color:white;

            transition:.25s;
        }

        .manual-verif-card .btn-save:hover{

            transform:translateY(-2px);

            box-shadow:
                0 10px 25px rgba(255,77,79,.35);
        }

        .swal-container-high {
            z-index: 100000 !important;
        }
        .swal2-container {
            z-index: 20000 !important;
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
                    <p>Candidature Licence (Accès S5)</p>

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

                    <div class="section-title">Bac+2</div>
                    <div class="info-row"><span class="info-label">Diplome</span><span class="info-value">{{ $etudiant->diplomedeug }}</span></div>
                    <div class="info-row"><span class="info-label">Établissement</span><span class="info-value">{{ $etudiant->etblsmtdeug }}</span></div>
                    <div class="info-row"><span class="info-label">Spécialité</span><span class="info-value">{{ $etudiant->specialitedeug }}</span></div>
                    <div class="info-row"><span class="info-label">Date d'obtention:</span><span class="info-value">{{ \Carbon\Carbon::parse($etudiant->date_obtention_deug)->format('d/m/Y') }}</span></div>
                    <div class="info-row"><span class="info-label">Mention</span><span class="info-value">{{ $etudiant->mentiondeug }}</span></div>
                    <div class="info-row"><span class="info-label">Moyenne</span><span class="info-value">{{ $etudiant->moyenne_deug }}</span></div>

                    <div class="section-title">Filière Licences (Accès S5)</div>
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
                                <span>Montant payé</span>
                                <span id="paymentAmount{{ $payment->id }}">
                                    {{ number_format($payment->montant_paye, 0, ',', ' ') }} MAD
                                </span>
                            </div>

                            <div class="payment-item">
                                <span>Date d’insertion</span>
                                <span>{{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}</span>
                            </div>

                        </div>
                        <div class="payment-item">
                            <span>Montant détecté (OCR)</span>
                            <span id="paymentStatus{{ $payment->id }}">
                                @if($payment->verification == 0)
                                    <span class="badge badge-pending">En cours de vérification</span>

                                @elseif($payment->verification == 1)
                                    <strong>
                                        {{ number_format($payment->montant_detecter, 0, ',', ' ') }} MAD
                                        <span class="badge badge-complete">Montant validé</span>
                                    </strong>

                                @elseif($payment->verification == 2)
                                    <strong>
                                        {{ number_format($payment->montant_detecter, 0, ',', ' ') }} MAD
                                    </strong>
                                    <br>
                                    <span class="badge badge-rejected">
                                        Vérification manuelle nécessaire
                                    </span>

                                @else
                                    <span class="badge badge-pending">Statut inconnu</span>
                                @endif
                            </span>
                        </div>
                        @if($payment->etat_payment !== "Complete(Fonctionnaire à l'UH1)")
                            {{-- Preview Button --}}
                            <button class="preview-btn"
                                onclick="openImage(
                                    '{{ asset($payment->document) }}',
                                    '{{ $payment->montant_detecter }}',
                                    '{{ $payment->verification }}',
                                    '{{ $payment->id }}'
                                )">
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
        <div class="image-modal" id="imageModal">

            <div class="receipt-modal-box">

                <div class="receipt-modal-header">
                    <h3>Reçu de Paiement</h3>
                    <button onclick="closeImage()" class="close-modal">✖</button>
                </div>

                <div class="receipt-modal-body">

                    <!-- LEFT = BIG RECEIPT -->
                    <div class="receipt-image-container">
                        <img id="modalImage" src="">
                    </div>

                    <!-- RIGHT = INFO PANEL -->
                    <div class="receipt-info">

                        <h4>Analyse du Reçu</h4>

                        <div class="receipt-info-row">
                            <span>Montant détecté</span>
                            <span id="ocrAmount"></span>
                        </div>

                        <div class="receipt-info-row">
                            <span>Statut vérification</span>
                            <span id="ocrStatus"></span>
                        </div>

                        <!-- ===== VERIFICATION MANUELLE FORM ===== -->
                        <div id="manualVerificationForm" style="display:none; margin-top:25px;">

                            <div class="manual-verif-card">
                                <div class="manual-verif-header">
                                    <i class="fa-solid fa-user-check"></i>
                                    <h4>Vérification manuelle</h4>
                                </div>

                                <p>Vous pouvez saisir le montant correct détecté pour ce paiement. Cette action est unique et valide directement le reçu.</p>

                                <form id="manualVerifyForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="manualMontant">Montant détecté (MAD)</label>
                                        <input type="number" step="0.01" class="form-control" id="manualMontant" name="montant_detecte" placeholder="Ex: 1200" required>
                                    </div>
                                    <button type="submit" class="btn-save">Valider</button>
                                </form>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    <script>
        function openImage(src, montant, verification, paymentId){

            document.getElementById("modalImage").src = src;

            let amountBox = document.getElementById("ocrAmount");
            let statusBox = document.getElementById("ocrStatus");
            let manualForm = document.getElementById("manualVerificationForm");
            let manualMontant = document.getElementById("manualMontant");

            if(montant && montant !== "null"){
                amountBox.innerHTML = new Intl.NumberFormat('fr-FR').format(montant) + " MAD";
                manualMontant.value = montant;
            }else{
                amountBox.innerHTML = '<span class="ocr-progress">Aucun montant détecté</span>';
                manualMontant.value = '';
            }

            if(verification == 0){
                statusBox.innerHTML = '<span class="ocr-progress">Analyse OCR en cours...</span>';
                manualForm.style.display = "block";
            }
            else if(verification == 1){
                statusBox.innerHTML = '<span class="ocr-valid">Montant validé ✅</span>';
                manualForm.style.display = "none";
            }
            else if(verification == 2){
                statusBox.innerHTML = '<span class="ocr-manual">Vérification manuelle requise ⚠️</span>';
                manualForm.style.display = "block";
            }

            manualForm.dataset.paymentId = paymentId;

            document.getElementById("imageModal").classList.add("active");
        }

        function closeImage() {
            document.getElementById('imageModal').classList.remove('active');
        }

        $('#manualVerifyForm').submit(function(e){

            e.preventDefault();

            let paymentId = $('#manualVerificationForm').data('paymentId');
            let montant = $('#manualMontant').val();
            let token = $('input[name="_token"]').val();

            $.ajax({
                url: `/sup-admin/paiement/${paymentId}/check/licence/auto`,
                type: "POST",
                data: {
                    _token: token,
                    montant_detecte: montant
                },

                success: function(res){

                    let paymentId = $('#manualVerificationForm').data('paymentId');
                    let formatted = new Intl.NumberFormat('fr-FR').format(res.montant) + " MAD";

                    // Update modal
                    $('#ocrAmount').html(formatted);

                    // Update payment card amount
                    $('#paymentStatus'+paymentId).html(
                        '<strong>'+formatted+'</strong><br>' +
                        '<span class="badge badge-complete">Montant validé</span>'
                    );

                    if(res.verification == 1){

                        $('#ocrStatus').html('<span class="ocr-valid">Montant validé ✅</span>');

                        $('#paymentStatus'+paymentId).html(
                            '<strong>'+formatted+'</strong><br>' +
                            '<span class="badge badge-complete">Montant validé</span>'
                        );

                        $('#manualVerificationForm').hide();

                        // SweetAlert for success
                        Swal.fire({
                            icon: 'success',
                            title: 'Montant validé',
                            text: `Le montant de ${formatted} a été validé avec succès.`,
                            timer: 2500,
                            showConfirmButton: false,
                            // ADD THIS:
                            customClass: {
                                container: 'swal-container-high'
                            }
                        });

                    } 
                    else if(res.verification == 2){

                        $('#ocrStatus').html('<span class="ocr-manual">Vérification manuelle requise ⚠️</span>');

                        $('#paymentStatus'+paymentId).html(
                            '<strong>'+formatted+'</strong><br>' +
                            '<span class="badge badge-rejected">Vérification manuelle nécessaire</span>'
                        );

                        // SweetAlert for warning
                        Swal.fire({
                            icon: 'warning',
                            title: 'Vérification manuelle nécessaire',
                            text: `Veuillez vérifier manuellement le montant de ${formatted}.`,
                            timer: 3000,
                            showConfirmButton: true,
                            customClass: {
                                container: 'swal-container-high'
                            }
                        });

                    }

                },

                error: function(xhr){

                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur serveur',
                        text: 'Une erreur est survenue, veuillez réessayer.',
                        confirmButtonText: 'OK',
                        customClass: {
                            container: 'swal-container-high'
                        }
                    });

                }

            });

        });
        
    </script>
    <script>

        function closeImage(){
            document.getElementById("imageModal").classList.remove("active");
        }

        // Close modal when clicking outside
        document.getElementById("imageModal").addEventListener("click", function(e){

            const modalBox = document.querySelector(".receipt-modal-box");

            if(!modalBox.contains(e.target)){
                closeImage();
            }

        });

    </script>

@endsection
