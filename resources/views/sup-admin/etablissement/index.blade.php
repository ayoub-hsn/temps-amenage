@extends('sup-admin.layouts.master')

@section('content')
<style>
    /* === GLOBAL === */
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #eef2f3 0%, #cfd9df 100%);
        margin: 0;
        padding: 0;
    }

    .main-content {
        min-height: 100vh;
        background: radial-gradient(circle at top right, #dfe9f3, #f8fbff);
    }

    .section h4 {
        font-weight: 700;
        font-size: 1.8rem;
        color: #222;
        margin-bottom: 25px;
    }

    /* === CARD === */
    .custom-card {
        position: relative;
        border-radius: 25px;
        background: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 30px 20px;
        margin-bottom: 30px;
        overflow: hidden;
        transition: all 0.5s ease;
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .custom-card::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle at top right, rgba(0, 150, 255, 0.08), transparent 70%);
        z-index: 0;
        transition: all 0.4s ease;
        pointer-events: none; /* ✅ Fix buttons not clickable */
    }


    .custom-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .custom-card:hover::before {
        background: radial-gradient(circle at top left, rgba(79, 172, 254, 0.2), transparent 70%);
    }

    /* === LOGO === */
    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 15px;
    }

    .logo {
        width: 100px;
        height: 100px;
        border-radius: 20px;
        object-fit: contain;
        background: #fff;
        padding: 8px;
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
        transition: transform 0.4s ease;
    }

    .custom-card:hover .logo {
        transform: scale(1.1);
    }

    /* === TITLES === */
    .card-title {
        font-size: 1.5rem;
        font-weight: 700;
        text-align: center;
        color: #2b2d42;
        margin-bottom: 6px;
    }

    .card-text {
        font-size: 1rem;
        color: #5c6c7a;
        text-align: center;
        margin-bottom: 25px;
    }

    /* === TOGGLES === */
    .toggle-container {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        margin-bottom: 20px;
    }

    .toggle-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 80%;
        font-weight: 500;
        font-size: 1rem;
        color: #333;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 65px;
        height: 30px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        inset: 0;
        background: linear-gradient(145deg, #dcdcdc, #f1f1f1);
        border-radius: 50px;
        cursor: pointer;
        transition: all 0.4s;
        box-shadow: inset 2px 2px 4px #c1c1c1, inset -2px -2px 5px #ffffff;
    }

    .toggle-slider:before {
        content: "";
        position: absolute;
        height: 22px;
        width: 22px;
        left: 4px;
        bottom: 4px;
        background-color: #fff;
        border-radius: 50%;
        transition: 0.4s;
        box-shadow: 0 3px 6px rgba(0,0,0,0.2);
    }

    input:checked + .toggle-slider {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        box-shadow: 0 0 12px rgba(56, 249, 215, 0.5);
    }

    input:checked + .toggle-slider:before {
        transform: translateX(34px);
    }

    /* === BUTTONS === */
    .btnn-group {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    .btnn-group .btn {
        flex: 1;
        text-align: center;
        padding: 10px 15px;
        border-radius: 30px;
        border: none;
        color: #fff;
        font-weight: 500;
        font-size: 1rem;
        letter-spacing: 0.3px;
        transition: all 0.3s ease;
    }

    .btn-warning {
        background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .btn-info {
        background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    }

    .btnn-group .btn:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 20px rgba(0,0,0,0.2);
    }

    /* === RESPONSIVE === */
    @media (max-width: 992px) {
        .toggle-item { width: 90%; }
    }

    @media (max-width: 768px) {
        .col-lg-4 { flex: 0 0 100%; max-width: 100%; }
        .custom-card { margin-bottom: 20px; }
        .btnn-group { flex-direction: column; }
        .btnn-group .btn { width: 100%; }
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Liste des établissements</h4>
                        <a href="{{ route('sup-admin.etablissement.create') }}" class="btn btn-primary">Créer un établissement</a>
                    </div>
                    
                      
                   
                    <div class="card-body">
                        <div class="row">
                            @foreach($etablissements as $etablissement)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="custom-card">
                                    <div class="logo-container">
                                        <img src="{{ asset($etablissement->logo) }}" alt="{{ $etablissement->nom }}" class="logo">
                                    </div>
                                    <h5 class="card-title">{{ $etablissement->nom_abrev }}</h5>
                                    <p class="card-text">{{ $etablissement->nom }}</p>

                                    <!-- Toggles -->
                                    <div class="toggle-container">
                                        <div class="toggle-item">
                                            <span>Master</span>
                                            <label class="toggle-switch">
                                                <input type="checkbox" onchange="toggleStatus('{{ $etablissement->id }}', 'master')" @if($etablissement->master_ouvert) checked @endif>
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                        <div class="toggle-item">
                                            <span>Licences (Accès S5)</span>
                                            <label class="toggle-switch">
                                                <input type="checkbox" onchange="toggleStatus('{{ $etablissement->id }}', 'passerelle')" @if($etablissement->passerelle_ouvert) checked @endif>
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                        <div class="toggle-item">
                                            <span>Licences (Accès S1)</span>
                                            <label class="toggle-switch">
                                                <input type="checkbox" onchange="toggleStatus('{{ $etablissement->id }}', 'bachelier')" @if($etablissement->bachelier_ouvert) checked @endif>
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Buttons -->
                                    <div class="btnn-group">
                                        <a href="{{ route('sup-admin.etablissement.edit', $etablissement->id) }}" class="btn btn-warning">Modifier</a>
                                        <a href="{{ route('sup-admin.etablissement.show', $etablissement->id) }}" class="btn btn-primary">Afficher</a>
                                        <a href="{{ route('sup-admin.etablissement.categorie.filiere', $etablissement->id) }}" class="btn btn-info">Filière</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
              
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function toggleStatus(id, type) {
    const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    const url = '{{ route("sup-admin.etablissement.togglePreInscription") }}';

    $.ajax({
        type: 'PATCH',
        url: url,
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
        data: { id: id, type: type },
        dataType: 'JSON',
        success: function (results) {
            Swal.fire("Succès!", results.message, "success");
        },
        error: function (error) {
            Swal.fire("Erreur!", "Veuillez réessayer plus tard.", "error");
            console.error(error);
        }
    });
}
</script>
@endsection
