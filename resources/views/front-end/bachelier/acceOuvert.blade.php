<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Université Hassan 1er</title>
    <link rel="stylesheet" href="{{asset('css/styles-welcomeLEM.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <style>
        .etablissements-section {
            padding: 60px 20px;
            background: #eef3f9;
            text-align: center;
        }

        .section-header h2 {
            font-size: 2.4rem;
            color: #004080;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .section-header p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 40px;
        }

        .etablissements-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 10px;
        }

        .etab-card {
            text-decoration: none;
            background-color: white;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            padding: 25px 20px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .etab-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 14px 30px rgba(0, 0, 0, 0.15);
        }

        .etab-logo-wrapper {
            height: 120px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .etab-logo {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }

        .etab-info {
            text-align: center;
        }

        .etab-title {
            font-size: 1.4rem;
            color: #004080;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .etab-name {
            font-size: 1rem;
            color: #666;
        }

    </style>

</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="{{asset('images/logos/uh1-vert-plus.PNG')}}" alt="Université Hassan 1er">
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('welcome') }}" {{ Route::currentRouteNamed('welcome') ? 'active' : '' }}>Accueil</a></li>
                <li><a href="{{ route('etablissements') }}" class="{{ Route::currentRouteNamed('etablissements') ? 'active' : '' }}">Etablissements</a></li>
                <li><a href="{{ route('contact') }}" class="{{ Route::currentRouteNamed('contact') ? 'active' : '' }}">Contact</a></li>
                <li><a href="{{ route('login') }}">Connexion</a></li>
            </ul>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
    </header>

    <main class="etablissements-section">
        <section class="section-header">
            <h2>Établissements avec Accès Ouvert à la Licence</h2>
            <p>Explorez les établissements de l’Université Hassan 1er qui proposent des licences ouvertes aux bacheliers.</p>
        </section>

        <div class="etablissements-grid">
            @foreach($etablissements as $etablissement)
                <a href="{{ route('bacheliers.acceeOuvert.etablissement.showForm',['etablissement' => $etablissement->id]) }}" class="etab-card">
                    <div class="etab-logo-wrapper">
                        <img src="{{ asset($etablissement->logo) }}" alt="{{ $etablissement->nom_abrev }}" class="etab-logo">
                    </div>
                    <div class="etab-info">
                        <h3 class="etab-title">{{ $etablissement->nom_abrev }}</h3>
                        <p class="etab-name">{{ $etablissement->nom }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </main>







    <footer>
        <p>&copy; 2025 Made By Ayoub Hassnioui. Tous droits réservés.</p>
        <div class="social-links">
            <a href="https://www.instagram.com/universitehassan/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/uh1" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/uh1" target="_blank"><i class="fab fa-twitter"></i></a>
        </div>
    </footer>

    <script src="{{asset('js/script.js')}}"></script>



</body>
</html>
