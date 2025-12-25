@extends('admin-etab.layouts.master')

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

</style>

<div class="main-content">
    <section class="section">
        <div class="container-fluid">

            <h2 class="page-title">🎓 Filières – Hassan Premier University - {{ $etablissement->nom_abrev }}</h2>

            <div class="card master-card">
                <div class="card-body">

                    @if ($etablissement->multiple_choix_filiere_master == 1)
                        <div class="mb-4">
                            <a href="{{ route('admin-etab.filiere.multiplechoix.master.etudiants.excel.download',['etablissement' => $etablissement->id]) }}"
                               class="btn btn-primary btn-lg" style="border-radius: 50px;">
                                Télécharger tous les étudiants postulants
                            </a>
                        </div>
                    @endif

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
                                <a href="{{ route('admin-etab.filiere.show', $filiere->id) }}"
                                   class="action-btn btn-view">
                                   Détails
                                </a>

                                <a href="{{ route('admin-etab.payment.master.filiere.students', $filiere->id) }}"
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

@endsection
