@extends('sup-admin.layouts.master')
@section('content')
<style>
    /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f6f9;
        margin: 0;
        padding: 0;
    }

    /* Card Layout */
    .custom-card {
        border-radius: 15px;
        background-color: #ffffff;
        padding: 20px;
        margin-bottom: 30px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .custom-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
    }

    /* Logo and Header */
    .logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 120px;
        margin-bottom: 20px;
    }

    .logo {
        width: 100px;
        height: 100px;
        object-fit: contain;
        border-radius: 10px;
        border: 2px solid #f2f2f2;
    }

    .card-title {
        font-size: 1.6rem;
        font-weight: 600;
        color: #333;
        text-align: center;
        margin-bottom: 10px;
        text-transform: uppercase;
    }

    .card-text {
        font-size: 1.1rem;
        color: #666;
        text-align: center;
        margin-bottom: 25px;
    }

    /* Toggle Switch for Pre-inscriptions */
    .toggle-container {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        font-size: 1rem;
        color: #333;
    }

    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 50px;
        height: 24px;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: 0.4s;
        border-radius: 50px;
    }

    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        border-radius: 50%;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: 0.4s;
    }

    input:checked + .toggle-slider {
        background-color: #4CAF50;
    }

    input:checked + .toggle-slider:before {
        transform: translateX(26px);
    }

    /* Buttons */
    .btnn-group {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
    }

    .btnn-group .btn {
        padding: 12px 25px;
        font-size: 1.1rem;
        font-weight: 500;
        border-radius: 30px;
        border: none;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
    background-color: #007bff;
    color: #fff;
    }

    .btn-info {
        background-color: #17a2b8;
        color: #fff;
    }

    .btn-primary:hover {
        color: #fff;
        background-color: #0056b3;
    }

    .btn-info:hover {
        color: #fff;
        background-color: #138496;
    }

    /* Responsive Layout */
    @media (max-width: 768px) {
        .col-lg-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .custom-card {
            margin-bottom: 20px;
        }
    }


</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header" style="justify-content: space-between;">
                        <h4>Liste des établissements</h4>
                        <a href="{{ route('sup-admin.etablissement.create') }}" class="btn btn-primary">Créer un établissement</a>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($etablissements as $etablissement)
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="logo-container">
                                            <img src="{{ asset($etablissement->logo) }}" alt="{{ $etablissement->nom }}" class="logo">
                                        </div>
                                        <h5 class="card-title">{{ $etablissement->nom_abrev }}</h5>
                                        <p class="card-text">{{ $etablissement->nom }}</p>

                                        <!-- Toggle Pre-inscription Status -->
                                        <div class="toggle-container">

                                            <div class="toggle-item">
                                                <strong>Master:</strong>
                                                <label class="toggle-switch">
                                                    <input type="checkbox" onchange="toggleStatus('{{ $etablissement->id }}', 'master')" @if($etablissement->master_ouvert) checked @endif>
                                                    <span class="toggle-slider"></span>
                                                </label>
                                            </div>
                                            <div class="toggle-item">
                                                <strong>Licence:</strong>
                                                <label class="toggle-switch">
                                                    <input type="checkbox" onchange="toggleStatus('{{ $etablissement->id }}', 'passerelle')" @if($etablissement->passerelle_ouvert) checked @endif>
                                                    <span class="toggle-slider"></span>
                                                </label>
                                            </div>
                                        </div>



                                        <!-- Button Group for Modifying/Deleting -->
                                        <div class="btnn-group">
                                            <!-- Modifier Button -->
                                            <a href="{{ route('sup-admin.etablissement.edit', $etablissement->id) }}" class="btn btn-warning">Modifier</a>

                                            <!-- Afficher Button -->
                                            <a href="{{ route('sup-admin.etablissement.show', $etablissement->id) }}" class="btn btn-primary">Afficher</a>

                                            <!-- Filière Button -->
                                            <a href="{{ route('sup-admin.etablissement.categorie.filiere', $etablissement->id) }}" class="btn btn-info">Filière</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    function toggleStatus(id, type) {
        // Retrieve the CSRF token
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var url = '{{ route("sup-admin.etablissement.togglePreInscription") }}';

        $.ajax({
            type: 'PATCH',
            url: url,
            headers: {
                'X-CSRF-TOKEN': CSRF_TOKEN // Include CSRF token in headers
            },
            data: {
                id: id,
                type: type // Include both parameters in the request body
            },
            dataType: 'JSON',
            success: function (results) {
                console.log(results);
                Swal.fire("Success!", results.message, "success");
            },
            error: function (error) {
                Swal.fire("Erreur!", "Refaire cette action après", "error");
                console.log(error);
            }
        });
    }

</script>

@endsection
