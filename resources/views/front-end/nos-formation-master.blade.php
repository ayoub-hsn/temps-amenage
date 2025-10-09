<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Université Hassan 1er - Formation Initiale à Temps Aménagé</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('css/style-welcome.css') }}" />

<style>

    /* ======= Base ======= */
    html, body {
    height: 100%;
    margin: 0;
    font-family: "Poppins", "Cairo", "Roboto", sans-serif;
    background: #f4f7fb;
    scroll-behavior: smooth;
    overflow-x: hidden;
    }

    main {
    flex: 1 0 auto;
    }

    /* ======= MAIN SECTION ======= */
    .formation-main {
    position: relative;
    min-height: 100vh;
    padding: 100px 25px;
    color: #fff;
    background: linear-gradient(135deg, #003366, #0059b3 50%, #001f4d 100%);
    overflow: hidden;
    z-index: 1;
    }

    /* === Elegant Particle Animation === */
    .formation-main::before {
    content: "";
    position: absolute;
    inset: 0;
    background: 
        radial-gradient(circle at 30% 40%, rgba(255, 200, 0, 0.25), transparent 70%),
        radial-gradient(circle at 80% 70%, rgba(0, 170, 255, 0.2), transparent 60%);
    animation: glowDrift 45s linear infinite alternate;
    filter: blur(3px);
    z-index: 0;
    }
    @keyframes glowDrift {
    0% { transform: translate(0, 0); }
    100% { transform: translate(-4%, -3%); }
    }

    .formation-main::after {
    content: "";
    position: absolute;
    inset: 0;
    background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px);
    background-size: 140px 140px;
    opacity: 0.4;
    animation: starfield 60s linear infinite;
    }
    @keyframes starfield {
    from { background-position: 0 0; }
    to { background-position: 1000px 1000px; }
    }

    /* ======= HEADER / WELCOME ======= */
    .welcome-section {
        text-align: center;
        margin-bottom: 80px;
        position: relative;
        z-index: 2;
        animation: fadeInUp 1.3s ease;
        }
        @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
        }
        .welcome-section h1 {
        font-size: 2.8rem;
        font-weight: 700;
        background: linear-gradient(90deg, #ffcc00, #00c6ff);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        text-shadow: 0 0 25px rgba(255,255,255,0.3);
        letter-spacing: 1px;
        }

    /* ======= University Logo Zone ======= */
    .etablissement-logo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 35px;
        position: relative;
    }

    .etablissement-logo {
        width: 170px;
        height: 170px;
        border-radius: 50%;
        background: radial-gradient(circle at 30% 30%, #ffffff, #f3f3f3);
        object-fit: contain;
        padding: 16px;
        box-shadow:
            0 0 25px rgba(255, 215, 0, 0.6),
            inset 0 0 12px rgba(0, 50, 150, 0.2);
        transition: all 0.6s ease-in-out;
        animation: floatLogo 6s ease-in-out infinite;
        position: relative;
    }

    /* ✨ Light Reflection Overlay on Logo */
    .etablissement-logo::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 200%;
        height: 200%;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.4), transparent);
        transform: rotate(25deg);
        animation: logoShine 5s linear infinite;
        border-radius: 50%;
    }

    @keyframes logoShine {
        0% { transform: translateX(-100%) rotate(25deg); opacity: 0; }
        50% { opacity: 1; }
        100% { transform: translateX(100%) rotate(25deg); opacity: 0; }
    }

    @keyframes floatLogo {
        0%, 100% { transform: translateY(0px) scale(1); }
        50% { transform: translateY(-8px) scale(1.03); }
    }

    .etablissement-logo:hover {
        transform: scale(1.1) rotate(3deg);
        box-shadow:
            0 0 60px rgba(255, 230, 100, 0.9),
            0 0 120px rgba(0, 150, 255, 0.6);
    }

    /* ======= Cards Grid ======= */
    .cards-container {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(310px, 1fr));
    gap: 40px;
    justify-items: center;
    align-items: stretch;
    margin: 0 auto 90px auto;
    max-width: 1400px;
    position: relative;
    z-index: 2;
    }

    /* ======= Filieres Card ======= */
    .formation-card {
    background: rgba(255, 255, 255, 0.06);
    border: 1px solid rgba(255,255,255,0.15);
    border-radius: 25px;
    padding: 35px;
    color: #fff;
    text-align: center;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.45);
    transition: all 0.4s ease;
    backdrop-filter: blur(15px);
    width: 100%;
    max-width: 360px;
    min-height: 440px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    transform: perspective(1000px) rotateX(0);
    }

    /* === Hover Magic === */
    .formation-card:hover {
    transform: perspective(1000px) rotateX(5deg) translateY(-15px) scale(1.05);
    background: linear-gradient(135deg, rgba(0,95,200,0.9), rgba(255,180,0,0.9));
    box-shadow: 0 30px 80px rgba(255, 200, 0, 0.7);
    }

    /* === Light Sweep Animation === */
    .formation-card::before {
    content: "";
    position: absolute;
    top: -50%;
    left: -60%;
    width: 220%;
    height: 220%;
    background: linear-gradient(120deg, transparent, rgba(255,255,255,0.25), transparent);
    transform: rotate(30deg);
    animation: shine 6s linear infinite;
    pointer-events: none;
    }
    @keyframes shine {
    0% { transform: translateX(-100%) rotate(30deg); }
    100% { transform: translateX(100%) rotate(30deg); }
    }

    /* ======= Filière Code ======= */
    .filiere-code {
    display: inline-block;
    background: linear-gradient(90deg, #004eff, #00d4ff);
    color: #fff;
    padding: 9px 22px;
    border-radius: 25px;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 18px;
    box-shadow: 0 0 20px rgba(0, 150, 255, 0.7);
    }

    /* ======= Filière Title ======= */
    .filiere-title {
    font-size: 1.5rem;
    font-weight: 700;
    margin-bottom: 30px;
    min-height: 70px;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #fff;
    text-shadow: 0 0 18px rgba(255,255,255,0.35);
    }

    /* ======= Badge ======= */
    .card-badge {
    position: absolute;
    top: 18px;
    right: 18px;
    background: linear-gradient(135deg, #ffcf00, #ff8000);
    color: #000;
    padding: 9px 16px;
    border-radius: 15px;
    font-weight: bold;
    font-size: 0.9rem;
    animation: pulseGlow 2.5s infinite;
    box-shadow: 0 0 20px rgba(255,200,0,0.8);
    }
    @keyframes pulseGlow {
    0%,100% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.15); opacity: 0.85; }
    }

    /* ======= Button ======= */
    .btn-preinscription {
    display: inline-block;
    background: linear-gradient(90deg, #ffb300, #ff6a00);
    padding: 12px 32px;
    border-radius: 30px;
    font-weight: 600;
    color: #fff;
    text-decoration: none;
    transition: all 0.4s ease;
    letter-spacing: 0.5px;
    }
    .btn-preinscription:hover {
    transform: scale(1.1);
    background: linear-gradient(90deg, #ffcf4b, #ff8800);
    box-shadow: 0 12px 35px rgba(255,180,0,0.65);
    }

    /* ======= No Filière ======= */
    .no-filiere {
    background: rgba(255,255,255,0.12);
    border-radius: 22px;
    padding: 45px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.3);
    text-align: center;
    font-size: 1.1rem;
    color: #eee;
    }

    /* ======= Responsive ======= */
    @media (max-width: 768px) {
    .etablissement-logo {
        width: 140px;
        height: 140px;
    }
    .formation-card {
        min-height: 400px;
        max-width: 90%;
    }
    .btn-preinscription {
        padding: 10px 22px;
        font-size: 0.9rem;
    }
    }

</style>

</head>
<body>

<header>
    <nav>
        <div class="logo"><img src="{{ asset('images/logos/uh1-vert-plus.PNG') }}" alt="Université Hassan 1er" /></div>
        <ul class="nav-links">
            <li><a href="{{ route('welcome') }}" class="{{ Route::currentRouteNamed('welcome') ? 'active' : '' }}">Accueil</a></li>
            <li><a href="{{ route('nosformation') }}" class="{{ Route::currentRouteNamed('nosformation') ? 'active' : '' }}">Formations</a></li>
            <li><a href="{{ route('contact') }}" class="{{ Route::currentRouteNamed('contact') ? 'active' : '' }}">Contact</a></li>
            <li><a href="{{ route('login') }}">Connexion</a></li>
        </ul>
    </nav>
</header>

<main class="formation-main">
    <div class="welcome-section text-center">
        <div class="etablissement-logo-container">
            <img src="{{ asset($etablissement->logo) }}" alt="Logo {{ $etablissement->nom }}" class="etablissement-logo">
        </div>
        <h1 class="display-4 fw-bold">
            <span class="highlight">{{ $etablissement->nom }}</span>
        </h1>
        <h2 class="etablissement-name">Formation Initiale à Temps Aménagé</h2>
        <p class="lead mt-3 mb-5">
             Masters Universitaires
        </p>
    </div>

    <!-- Cartes des formations -->
    <!-- Cartes des formations -->
<section id="formations" class="formations-list">
    <div class="cards-container">
        @forelse($filieresMaster as $filiere)
            <div class="formation-card">
                <!-- Badge Master -->
                <span class="card-badge">Master</span>

                <span class="filiere-code">{{ $filiere->nom_abrv }}</span>
                <h3 class="filiere-title">{{ $filiere->nom_complet }}</h3>

                <!-- Bouton Préinscription -->
                <a href="{{ route('nosformationChoisen', ['id' => $filiere->id]) }}" class="btn-preinscription">
                    📥 Préinscription
                </a>
            </div>
        @empty
            <div class="no-filiere text-center" style="grid-column: 1 / -1; padding: 40px; color: white;">
                <i class="fas fa-info-circle fa-2x mb-3"></i>
                <p>Aucune filière Master trouvée pour le moment.</p>
            </div>
        @endforelse
    </div>
</section>

</main>

<footer>
    <p>&copy; 2025 Université Hassan 1er. Tous droits réservés.</p>
    <div class="social-links">
        <a href="https://www.instagram.com/universitehassan/" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://www.facebook.com/uh1" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://twitter.com/uh1" target="_blank"><i class="fab fa-twitter"></i></a>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>
