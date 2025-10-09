@extends('admin-etab.layouts.master')

@section('content')
<style>
    /* Global styles */
   

    /* Hover and transition effects */
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 15px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease-in-out;
        background: rgba(255, 255, 255, 0.1); /* Glass effect */
        backdrop-filter: blur(10px);
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
    }

    /* Title and header */
    .card-header {
        background: rgba(0, 0, 0, 0.4);
        color: #fff;
        font-size: 1.5rem;
        font-weight: 600;
        border-radius: 20px 20px 0 0;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-body {
        padding: 20px;
    }

    .badge {
        font-size: 0.9rem;
        font-weight: bold;
        padding: 8px 15px;
        border-radius: 30px;
        background: linear-gradient(145deg, #ff6a00, #ee0979);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }

    /* Buttons */
    .btn-primary {
        background: linear-gradient(145deg, #ff6a00, #ee0979);
        border-radius: 30px;
        color: white;
        padding: 10px 20px;
        font-weight: bold;
        transition: transform 0.3s ease;
    }

    .btn-primary:hover {
        transform: scale(1.1);
        background: linear-gradient(145deg, #ee0979, #ff6a00);
    }

    .btn-light {
        background-color: rgba(255, 255, 255, 0.3);
        color: #fff;
        font-weight: bold;
        border-radius: 30px;
        padding: 10px 20px;
    }

    /* Card Image and Badge Styling */
    .card-img-container {
        position: relative;
        height: 300px;
        border-radius: 20px;
        overflow: hidden;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease-in-out;
    }

    .card-img-container:hover .card-img-top {
        transform: scale(1.1);
    }

    .badge-status {
        position: absolute;
        top: 10px;
        left: 10px;
        background: rgba(0, 0, 0, 0.6);
        color: white;
        font-size: 1rem;
        font-weight: bold;
        padding: 10px 20px;
        border-radius: 25px;
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        transition: opacity 0.3s ease;
    }

    /* Card Body Title */
    .card-title {
        font-size: 1.2rem;
        font-weight: 500;
        color: #145d93;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    }

    .card-text {
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.8);
        margin-bottom: 10px;
    }

    .text-small {
        font-size: 0.85rem;
        color: rgba(255, 255, 255, 0.7);
    }

    /* Layout adjustments */
    .row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .col-md-6 {
        flex: 0 0 48%;
        max-width: 48%;
    }

    .col-lg-4 {
        flex: 0 0 30%;
        max-width: 30%;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .col-md-6, .col-lg-4 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    /* Alert Styling */
    .alert-warning {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffcc00;
        border: 1px solid #ffcc00;
        font-size: 1rem;
        font-weight: bold;
    }
</style>

<div class="main-content">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary">
                        <h4>Liste des actualités</h4>
                        <a href="{{ route('admin-etab.actualite.create') }}" class="btn btn-light btn-sm">
                            Ajouter une actualité
                        </a>
                    </div>
                    <div class="card-body">
                        @if($actualites->isEmpty())
                            <div class="alert alert-warning text-center">
                                <strong style="color: white;">Aucune actualité n'est disponible actuellement.</strong>
                            </div>
                        @else
                            <div class="row">
                                @foreach($actualites as $actualite)
                                    <div class="col-md-6 col-lg-4">
                                        <div class="card shadow-sm rounded-lg overflow-hidden">
                                            <div class="card-img-container">
                                                <img src="{{ asset($actualite->image) }}" class="card-img-top" alt="Image de {{ $actualite->titre }}">
                                                <span class="badge-status {{ \Carbon\Carbon::now()->lessThan(\Carbon\Carbon::createFromFormat('Y-m-d', $actualite->published_at)) || \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::createFromFormat('Y-m-d', $actualite->finished_at)) ? 'bg-warning' : 'bg-success' }}">
                                                    {{ \Carbon\Carbon::now()->lessThan(\Carbon\Carbon::createFromFormat('Y-m-d', $actualite->published_at)) || \Carbon\Carbon::now()->greaterThan(\Carbon\Carbon::createFromFormat('Y-m-d', $actualite->finished_at)) ? 'Non publié' : 'Publié' }}
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <h5 class="card-title"> {!! \Illuminate\Support\Str::limit(strip_tags($actualite->titre), 80, '...') !!}</h5>
                                                
                                                <p class="card-text">
                                                    {!! \Illuminate\Support\Str::limit(strip_tags($actualite->description), 250, '...') !!}
                                                </p>

                                                <p class="text-small">
                                                    Publié par : {{ $actualite->owner->name ?? 'Inconnu' }} <br>
                                                    Publié le : {{ \Carbon\Carbon::parse($actualite->published_at)->format('d M Y') }}
                                                </p>
                                                
                                                <a href="{{ route('admin-etab.actualite.show', $actualite->id) }}" class="btn btn-primary btn-sm btn-block">
                                                    Voir plus
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection
