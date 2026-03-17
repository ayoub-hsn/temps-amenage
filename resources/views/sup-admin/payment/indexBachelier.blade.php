@extends('sup-admin.layouts.master')

@section('content')

<style>

    /* SECTION TITLE */
    .page-title {
        font-size: 2.3rem;
        font-weight: 700;
        color: #1e3050;
        margin-bottom: 25px;
        text-align: center;
    }

    /* CARD WRAPPER */
    .master-card {
        border-radius: 18px;
        background: #ffffff;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.07);
    }

    /* SMART GRID – SAME WIDTH & SAME HEIGHT */
    .filiere-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(330px, 1fr));
        gap: 28px;
        align-items: stretch;
    }

    /* SMART TILE – FLEXBOX FIX */
    .filiere-tile {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        background: #ffffff;
        transition: 0.45s ease;
        box-shadow: 0 10px 30px rgba(0,0,0,0.07);

        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .filiere-tile:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 45px rgba(0,0,0,0.15);
    }

    /* HEADER BANNER */
    .filiere-banner {
        height: 140px;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        display: flex;
        align-items: center;
        padding: 20px;
        color: #fff;
        font-size: 1.8rem;
        font-weight: 700;
        position: relative;
    }

    /* STATUS PILL */
    .status-pill {
        position: absolute;
        top: 15px;
        right: 15px;
        padding: 6px 16px;
        color: #fff;
        font-weight: 700;
        font-size: 0.9rem;
        border-radius: 50px;
        text-transform: uppercase;
    }

    .status-active { background:#28a745; }
    .status-inactive { background:#dc3545; }

    /* CONTENT */
    .filiere-content {
        padding: 20px;
        font-size: 0.95rem;
        flex-grow: 1; /* pushes footer to remain at bottom */
    }

    .filiere-full-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .count-badge {
        display: inline-block;
        padding: 4px 12px;
        background: #2575fc;
        color: #fff;
        font-weight: 700;
        border-radius: 50px;
        font-size: 0.9rem;
    }

    .info-line {
        margin-bottom: 10px;
        font-weight: 600;
        color: #333;
    }

    .info-line i {
        color: #2575fc;
        margin-right: 8px;
    }

    /* FOOTER ACTIONS */
    .filiere-footer {
        padding: 20px;
        display: flex;
        justify-content: space-between;
        border-top: 1px solid #e6e6e6;
    }

    .action-btn {
        padding: 10px 22px;
        border-radius: 50px;
        font-weight: 600;
        transition: 0.3s;
        font-size: 1rem;
        text-transform: uppercase;
    }

    .btn-view {
        background: #2575fc;
        color: #fff;
    }

    .btn-students {
        background: #f0f0f0;
        color: #333;
    }

    .action-btn:hover {
        transform: scale(1.1);
    }

    /* DOCUMENT BUTTON */
    .doc-btn {
        margin-top: 12px;
        display: inline-block;
        padding: 10px 15px;
        border-radius: 12px;
        background: #6a11cb;
        color: #fff;
        font-weight: 600;
        transition: 0.3s;
        text-decoration: none;
    }

    .doc-btn:hover {
        background: #2575fc;
        transform: translateY(-3px);
    }

    /* ===========================
    CHECK ALL BUTTON – PREMIUM
    =========================== */

    .check-all-btn {
        padding: 14px 38px;
        border: none;
        border-radius: 50px;
        font-size: 1.05rem;
        font-weight: 700;
        color: #fff;
        background: linear-gradient(135deg, #ff512f, #dd2476);
        box-shadow: 0 12px 25px rgba(221,36,118,0.35);
        cursor: pointer;
        transition: 0.35s ease;
    }

    .check-all-btn:hover {
        transform: translateY(-4px);
        box-shadow: 0 18px 40px rgba(221,36,118,0.55);
    }

    .check-all-btn.loading {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
    }

</style>

<div class="main-content">
    <section class="section">
        <div class="container-fluid">

            <h2 class="page-title">🎓 Filières – Hassan Premier University - {{ $etablissement->nom_abrev }}</h2>

            <div class="text-center mb-4">

                <button id="btn-check-all" class="check-all-btn">
                    🔍 Vérifier Tous les Reçus
                </button>

            </div>

            <div class="card master-card">
                <div class="card-body">

                    @if($filieres->isEmpty())
                        <div class="alert alert-warning text-center">Aucun filière trouvé.</div>
                    @else

                    <div class="filiere-grid">

                        @foreach($filieres as $filiere)
                        <div class="filiere-tile">

                            <!-- HEADER -->
                            <div class="filiere-banner">
                                {{ $filiere->nom_abrv }}

                                <div class="status-pill 
                                    {{ $filiere->active ? 'status-active' : 'status-inactive' }}">
                                    {{ $filiere->active ? 'Active' : 'Inactive' }}
                                </div>
                            </div>

                            <!-- CONTENT -->
                            <div class="filiere-content">

                                <div class="filiere-full-name">{{ $filiere->nom_complet }}</div>

                                <div class="info-line">
                                    <i class="fas fa-user-tie"></i>
                                    Responsable : {{ $filiere->responsable ?? 'Non défini' }}
                                </div>

                                <div class="info-line">
                                    <i class="fas fa-user-graduate"></i>
                                    Étudiants payants :
                                    <span class="count-badge">{{ $filiere->students_count }}</span>
                                </div>

                                @if($filiere->document)
                                    <a href="{{ asset($filiere->document) }}" target="_blank" class="doc-btn">
                                        📄 Voir le document
                                    </a>
                                @endif

                            </div>

                            <!-- FOOTER -->
                            <div class="filiere-footer">
                                <a href="{{ route('sup-admin.filiere.show', $filiere->id) }}"
                                   class="action-btn btn-view">
                                   Détails
                                </a>

                                <a href="{{ route('sup-admin.payment.bachelier.filiere.students', $filiere->id) }}"
                                   class="action-btn btn-students">
                                   Étudiants
                                </a>
                            </div>

                        </div>
                        @endforeach

                    </div>

                    @endif

                </div>
            </div>

        </div>
    </section>
</div>
<script>
    $(document).ready(function() {

        $('#btn-check-all').on('click', function() {

            let button = $(this);

            if (button.hasClass('loading')) return;

            button.addClass('loading')
                .prop('disabled', true)
                .html('⏳ Vérification en cours...');

            Swal.fire({
                title: 'Vérification en cours...',
                html: 'Initialisation...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // 1️⃣ Start queue dispatch
            $.ajax({
                url: "{{ route('sup-admin.payment.bachelier.checkAll') }}",
                type: "POST",
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function(startResponse) {

                    let total = startResponse.total ?? 0;

                    if (total === 0) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Aucun reçu à vérifier'
                        });

                        button.removeClass('loading')
                            .prop('disabled', false)
                            .html('🔍 Vérifier Tous les Reçus');

                        return;
                    }

                    // 2️⃣ Start polling progress
                    let interval = setInterval(function() {

                        $.ajax({
                            url: "{{ route('sup-admin.payment.bachelier.checkAllProgress') }}",
                            type: "GET",
                            success: function(progress) {

                                let validated = progress.validated ?? 0;
                                let manual    = progress.manual ?? 0;
                                let pending   = progress.pending_db ?? 0;

                                let analysed = validated + manual;
                                let percentage = Math.round((analysed / total) * 100);

                                Swal.update({
                                    html: `
                                        <div style="text-align:left;font-size:14px">
                                            <b>Progression : ${percentage}%</b><br><br>
                                            ✔ Validés : ${validated}<br>
                                            ⚠ À vérifier manuellement : ${manual}<br>
                                            ⏳ Restants : ${pending}
                                        </div>
                                    `
                                });

                                // 3️⃣ Finish condition
                                if (pending == 0) {

                                    clearInterval(interval);

                                    button.removeClass('loading')
                                        .prop('disabled', false)
                                        .html('🔍 Vérifier Tous les Reçus');

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Vérification Terminée ✅',
                                        html: `
                                            ✔ Validés : ${validated}<br>
                                            ⚠ Manuel : ${manual}
                                        `
                                    });
                                }

                            }
                        });

                    }, 3000); // every 3 seconds

                },
                error: function(xhr) {

                    button.removeClass('loading')
                        .prop('disabled', false)
                        .html('🔍 Vérifier Tous les Reçus');

                    let errorMessage = "Une erreur est survenue.";

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur ❌',
                        text: errorMessage
                    });
                }
            });

        });

    });
</script>
@endsection
