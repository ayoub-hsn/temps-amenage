<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Université Hassan 1er - Formation Initiale en Temps Aménagé</title>
    <link rel="stylesheet" href="{{asset('css/styles-welcomeLEM.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
       @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Inter:wght@400;600&display=swap');

        .uhp-annonce-section {
        display: flex;
        justify-content: center;
        padding: 80px 20px;
        background: linear-gradient(135deg, #ffffff, #ffffff);
        font-family: 'Inter', sans-serif;
        }

        .uhp-annonce-card {
        max-width: 950px;
        width: 100%;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        transition: all 0.3s ease-in-out;
        }

        .uhp-annonce-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
        }

        .uhp-image-wrapper {
        max-height: 400px;
        overflow: hidden;
        }

        .uhp-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        }

        .uhp-annonce-card:hover .uhp-image {
        transform: scale(1.05);
        }

        .uhp-annonce-content {
        padding: 40px 35px;
        }

        .uhp-title {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        color: #003366;
        margin-bottom: 20px;
        text-align: center;
        }

        .uhp-description {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #333;
        }

        .uhp-description a {
        color: #0051ba;
        font-weight: 600;
        text-decoration: underline;
        transition: color 0.3s ease;
        }

        .uhp-description a:hover {
        color: #003399;
        }

        @media (max-width: 768px) {
        .uhp-annonce-content {
            padding: 25px 20px;
        }

        .uhp-title {
            font-size: 1.8rem;
        }

        .uhp-description {
            font-size: 1rem;
        }
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

    <main class="uhp-annonce-section">
        <section class="uhp-annonce-card">
          <div class="uhp-image-wrapper">
            <img src="{{ asset($actualite->image) }}" alt="{{ $actualite->titre }}" class="uhp-image" />
          </div>
          <div class="uhp-annonce-content">
            <h1 class="uhp-title">{{ $actualite->titre }}</h1>
            <div class="uhp-description">
              {!! $actualite->description !!}
            </div>
          </div>
        </section>
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
