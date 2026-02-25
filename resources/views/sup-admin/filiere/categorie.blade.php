@extends('sup-admin.layouts.master')
@section('content')

<style>
    body {
        background: linear-gradient(135deg, #eef2f7, #fff);
    }

    .categorie-header {
        background: linear-gradient(90deg, #004e92, #000428);
        color: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 40px;
        text-align: center;
        box-shadow: 0 8px 25px rgba(0,0,0,0.3);
    }

    .background-container {
        background: white;
        border-radius: 20px;
        box-shadow: 0 12px 35px rgba(0,0,0,0.15);
        padding: 30px;
        margin-bottom: 40px;
    }

    .filiere-card {
        background: #f9fbfd;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        overflow: hidden;
        position: relative;
        height: 100%;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        border-top: 5px solid #004e92;
    }

    .filiere-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 35px rgba(0,0,0,0.2);
    }

    .filiere-abbr {
        font-size: 1.6rem;
        font-weight: bold;
        color: #004e92;
        margin-bottom: 8px;
    }

    .filiere-name {
        font-size: 1.25rem;
        font-weight: 700;
        margin-bottom: 12px;
        color: #333;
    }

/* =========================================
   ULTRA PREMIUM 2026 TOGGLE DESIGN
========================================= */

.status-toggle {
    position: absolute;
    top: 18px;
    right: 20px;

    width: 150px;
    height: 44px;

    border-radius: 40px;

    cursor: pointer;

    backdrop-filter: blur(12px);
    background: rgba(255,255,255,0.7);

    box-shadow:
        0 8px 25px rgba(0,0,0,0.12),
        inset 0 2px 8px rgba(255,255,255,0.9);

    overflow: hidden;

    transition: all 0.4s ease;
}

/* Sliding glass layer */
.status-toggle .toggle-glass {
    position: absolute;
    width: 50%;
    height: 90%;
    top: 2px;

    border-radius: 40px;

    transition: all 0.4s cubic-bezier(.68,-0.55,.27,1.55);
}

/* Track text */
.toggle-track {
    position: relative;
    z-index: 2;

    height: 100%;

    display: flex;
    align-items: center;
    justify-content: space-between;
}

.toggle-text {
    width: 50%;
    text-align: center;

    font-weight: 700;
    font-size: 0.85rem;

    transition: all 0.3s ease;
}

/* ACTIVE STATE */
.status-toggle.active {
    border: 1px solid rgba(40,167,69,0.3);
}

.status-toggle.active .toggle-glass {
    left: 3px;

    background: linear-gradient(
        135deg,
        #28a745,
        #20c997
    );

    box-shadow:
        0 6px 18px rgba(40,167,69,0.5);
}

.status-toggle.active .active-text {
    color: white;
}

.status-toggle.active .inactive-text {
    color: #999;
}

/* INACTIVE STATE */
.status-toggle.inactive {
    border: 1px solid rgba(220,53,69,0.3);
}

.status-toggle.inactive .toggle-glass {
    left: 50%;

    background: linear-gradient(
        135deg,
        #dc3545,
        #ff6b81
    );

    box-shadow:
        0 6px 18px rgba(220,53,69,0.5);
}

.status-toggle.inactive .inactive-text {
    color: white;
}

.status-toggle.inactive .active-text {
    color: #999;
}

/* Hover effect */
.status-toggle:hover {
    transform: scale(1.07);
}

    .filiere-info {
        font-size: 0.95rem;
        color: #555;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .filiere-info i {
        margin-right: 6px;
        color: #004e92;
    }

    .btn-view, .btn-doc, .btn-download {
        margin-top: 10px;
        width: 100%;
        font-weight: 600;
        transition: all 0.3s ease;
        border-radius: 10px;
    }

    .btn-view:hover, .btn-doc:hover, .btn-download:hover {
        transform: scale(1.05);
    }

    /* Modern gradient buttons */
    .btn-download {
        background: linear-gradient(90deg, #004e92, #007bff);
        color: white;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }

    .btn-download.green {
        background: linear-gradient(90deg, #2ecc71, #27ae60);
        box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
    }

    .btn-download.gold {
        background: linear-gradient(90deg, #f1c40f, #f39c12);
        box-shadow: 0 5px 15px rgba(241, 196, 15, 0.3);
    }

    .btn-download i {
        margin-right: 8px;
    }

    /* =========================================
    MODERN SINGLE-LINE VERIFIED BUTTON
    ========================================= */
    .btn-verified {
        width: 100%;
        margin-top: 12px;
        padding: 12px 16px;
        border-radius: 12px;
        border: none;
        cursor: pointer;

        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;

        font-weight: 600;
        font-size: 0.9rem;
        white-space: nowrap;        /* 🔥 Force single line */
        overflow: hidden;
        text-overflow: ellipsis;

        background: linear-gradient(135deg, #1e3c72, #2a5298);
        color: white;

        box-shadow: 0 8px 20px rgba(30, 60, 114, 0.35);
        transition: all 0.3s ease;
    }

    /* Icon container */
    .btn-verified .icon-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Hover effect */
    .btn-verified:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(30, 60, 114, 0.45);
    }

    .section-title {
        font-size: 1.6rem;
        font-weight: bold;
        margin: 30px 0 25px;
        color: #004e92;
        display: flex;
        align-items: center;
    }

    .section-title i {
        margin-right: 10px;
    }

    .filiere-card.green-border {
        border-top-color: #28a745;
    }
</style>

<div class="main-content">
    <section class="section">

        {{-- Header --}}
        <div class="categorie-header">
            <h3>Catégories des Filières - Université Hassan Premier</h3>
        </div>

        <div class="container">

            {{-- Filières Master --}}
            <div class="background-container">
                <h5 class="section-title">
                    <i data-feather="layers"></i> Filières Master ({{ $filieresMaster->count() }})
                </h5>

                <div class="row">
                    @forelse($filieresMaster as $filiere)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="filiere-card h-100">
                                <div class="filiere-abbr">{{ $filiere->nom_abrv }}</div>
                                <div class="filiere-name">{{ $filiere->nom_complet }}</div>

                                <div 
                                    class="status-toggle {{ $filiere->active ? 'active' : 'inactive' }}"
                                    data-id="{{ $filiere->id }}"
                                    data-status="{{ $filiere->active }}"
                                >
                                    <div class="toggle-glass"></div>

                                    <div class="toggle-track">
                                        <span class="toggle-text active-text">Active</span>
                                        <span class="toggle-text inactive-text">Inactive</span>
                                    </div>
                                </div>

                                <p class="filiere-info">
                                    <i data-feather="users"></i>
                                    Étudiants postulants : <strong>{{ $filiere->students_count }}</strong>
                                </p>

                                <p class="filiere-info">
                                    <i data-feather="user"></i>
                                    Responsable : <strong>{{ $filiere->responsable ?? '-' }}</strong>
                                </p>

                                @if($filiere->document)
                                    <a href="{{ asset($filiere->document) }}" target="_blank" class="btn btn-outline-secondary btn-doc">
                                        <i data-feather="file-text"></i> Consulter le document
                                    </a>
                                @endif

                                <a href="{{ route('sup-admin.etablissement.filiere.master.etudiants', $filiere->id) }}" class="btn btn-outline-primary btn-view">
                                    <i data-feather="eye"></i> Voir les étudiants
                                </a>

                                {{-- Download Excel --}}
                                <form action="{{ route('sup-admin.filiere.master.etudiants.excel.download', $filiere->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-download">
                                        <i data-feather="download"></i> Télécharger la liste
                                    </button>
                                </form>

                                {{-- Download Verified Students Excel --}}
                                <form action="{{ route('sup-admin.filiere.master.etudiants.verified.excel.download', $filiere->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-verified">
                                        <span class="icon-wrapper">
                                            <i data-feather="check-circle"></i>
                                        </span>
                                        Liste des étudiants admis
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">Aucune filière Master trouvée.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Licences (Accès S5) --}}
            <div class="background-container">
                <h5 class="section-title text-success">
                    <i data-feather="award"></i> Licences (Accès S5) ({{ $filieresPasserelle->count() }})
                </h5>

                <div class="row">
                    @forelse($filieresPasserelle as $filiere)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="filiere-card h-100 green-border">
                                <div class="filiere-abbr">{{ $filiere->nom_abrv }}</div>
                                <div class="filiere-name">{{ $filiere->nom_complet }}</div>

                                <div 
                                    class="status-toggle {{ $filiere->active ? 'active' : 'inactive' }}"
                                    data-id="{{ $filiere->id }}"
                                    data-status="{{ $filiere->active }}"
                                >
                                    <div class="toggle-glass"></div>

                                    <div class="toggle-track">
                                        <span class="toggle-text active-text">Active</span>
                                        <span class="toggle-text inactive-text">Inactive</span>
                                    </div>
                                </div>

                                <p class="filiere-info">
                                    <i data-feather="users"></i>
                                    Étudiants postulants : <strong>{{ $filiere->students_count }}</strong>
                                </p>

                                <p class="filiere-info">
                                    <i data-feather="user"></i>
                                    Responsable : <strong>{{ $filiere->responsable ?? '-' }}</strong>
                                </p>

                                @if($filiere->document)
                                    <a href="{{ asset($filiere->document) }}" target="_blank" class="btn btn-outline-secondary btn-doc">
                                        <i data-feather="file-text"></i> Consulter le document
                                    </a>
                                @endif

                                <a href="{{ route('sup-admin.etablissement.filiere.passerelle.etudiants', $filiere->id) }}" class="btn btn-outline-success btn-view">
                                    <i data-feather="eye"></i> Voir les étudiants
                                </a>

                                {{-- Download Excel --}}
                                <form action="{{ route('sup-admin.filiere.licence.etudiants.excel.download', $filiere->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-download green">
                                        <i data-feather="download"></i> Télécharger la liste
                                    </button>
                                </form>

                                <form action="{{ route('sup-admin.filiere.licence.etudiants.verified.excel.download', $filiere->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-verified">
                                        <span class="icon-wrapper">
                                            <i data-feather="check-circle"></i>
                                        </span>
                                        Liste des étudiants admis
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">Aucune filière Licence trouvée.</div>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Licences (Accès S1) --}}
            <div class="background-container">
                <h5 class="section-title text-warning">
                    <i data-feather="award"></i> Licences (Accès S1) ({{ $filieresBachelier->count() }})
                </h5>

                <div class="row">
                    @forelse($filieresBachelier as $filiere)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="filiere-card h-100 green-border">
                                <div class="filiere-abbr">{{ $filiere->nom_abrv }}</div>
                                <div class="filiere-name">{{ $filiere->nom_complet }}</div>

                                <div 
                                    class="status-toggle {{ $filiere->active ? 'active' : 'inactive' }}"
                                    data-id="{{ $filiere->id }}"
                                    data-status="{{ $filiere->active }}"
                                >
                                    <div class="toggle-glass"></div>

                                    <div class="toggle-track">
                                        <span class="toggle-text active-text">Active</span>
                                        <span class="toggle-text inactive-text">Inactive</span>
                                    </div>
                                </div>

                                <p class="filiere-info">
                                    <i data-feather="users"></i>
                                    Étudiants postulants : <strong>{{ $filiere->students_count }}</strong>
                                </p>

                                <p class="filiere-info">
                                    <i data-feather="user"></i>
                                    Responsable : <strong>{{ $filiere->responsable ?? '-' }}</strong>
                                </p>

                                @if($filiere->document)
                                    <a href="{{ asset($filiere->document) }}" target="_blank" class="btn btn-outline-secondary btn-doc">
                                        <i data-feather="file-text"></i> Consulter le document
                                    </a>
                                @endif

                                <a href="{{ route('sup-admin.etablissement.filiere.bachelier.etudiants', $filiere->id) }}" class="btn btn-outline-success btn-view">
                                    <i data-feather="eye"></i> Voir les étudiants
                                </a>

                                {{-- Download Excel --}}
                                <form action="{{ route('sup-admin.filiere.bachelier.etudiants.excel.download', $filiere->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-download gold">
                                        <i data-feather="download"></i> Télécharger la liste
                                    </button>
                                </form>

                                <form action="{{ route('sup-admin.filiere.bachelier.etudiants.verified.excel.download', $filiere->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-verified">
                                        <span class="icon-wrapper">
                                            <i data-feather="check-circle"></i>
                                        </span>
                                        Liste des étudiants admis
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info">Aucune filière Licence trouvée.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>
<script>
    $(document).ready(function(){

        $('.status-toggle').on('click', function(){

            let toggle = $(this);
            let filiereId = toggle.data('id');
            let currentStatus = toggle.data('status');

            let actionUrl = currentStatus == 1 
                ? "{{ url('sup-admin/filiere') }}/" + filiereId + "/desactive"
                : "{{ url('sup-admin/filiere') }}/" + filiereId + "/active";

            let actionText = currentStatus == 1 
                ? "désactiver" 
                : "activer";

            Swal.fire({
                title: "Confirmer l'action",
                text: "Voulez-vous vraiment " + actionText + " cette filière ?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Oui",
                cancelButtonText: "Annuler",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33"
            }).then((result) => {

                if (!result.isConfirmed) return;

                $.ajax({
                    url: actionUrl,
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response){

                        if(response.success){

                            let icon = toggle.find('i');
                            let text = toggle.find('.status-text');

                            if(currentStatus == 1){

                                toggle.removeClass('active')
                                    .addClass('inactive')
                                    .data('status', 0);

                                text.text('Inactive');
                                icon.attr('data-feather','x-circle');

                            } else {

                                toggle.removeClass('inactive')
                                    .addClass('active')
                                    .data('status', 1);

                                text.text('Active');
                                icon.attr('data-feather','check-circle');
                            }

                            feather.replace();

                            Swal.fire({
                                icon: "success",
                                title: response.message,
                                timer: 1200,
                                showConfirmButton: false
                            });

                        }
                    }

                });

            });

        });

    });
</script>
@endsection
