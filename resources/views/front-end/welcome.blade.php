<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Université Hassan 1er</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style-welcome.css') }}" />
    <style>
        /* ======= MAIN - Design harmonisé ======= */

        main {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #222;
            background: #f0f4fb; /* Bleu très clair, doux pour fond principal */
            padding: 60px 20px;
        }

        /* Titres sections */
        .section-title {
            font-weight: 700;
            font-size: 2.8rem;
            color: #003366; /* Bleu foncé */
            margin-bottom: 1.8rem;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            font-family: 'Montserrat', sans-serif;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Sections full width, contenu centré via container */
        main section {
            width: 100%;
            max-width: 100%;
            margin: 0 0 80px 0;
            padding: 40px 0; /* padding horizontal supprimé */
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 64, 128, 0.08);
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.7s ease, transform 0.7s ease;
        }

        /* Section visible après animation */
        main section.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Cartes avantages */
        .card {
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 64, 128, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #f9fbff;
            cursor: default;
        }

        .card:hover {
            transform: translateY(-12px);
            box-shadow: 0 20px 40px rgba(0, 64, 128, 0.3);
        }

        /* Titres des cartes */
        .card-title {
            font-weight: 700;
            color: #004080;
            margin-bottom: 1rem;
            font-size: 1.3rem;
        }

        /* Icônes des cartes */
        .card i.fas {
            color: #0066cc;
            margin-bottom: 15px;
        }

        /* Chiffres clés */
        #stats-section h3 {
            font-size: 4rem;
            font-weight: 800;
            color: #0059b3;
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
            font-family: 'Montserrat', sans-serif;
        }

        #stats-section p {
            font-size: 1.1rem;
            color: #444;
            font-weight: 600;
        }

        /* Domaines formation */
        .row-cols-1.row-cols-md-3 > .col > div {
            background: #e9f0ff;
            padding: 2rem;
            font-weight: 700;
            font-size: 1.15rem;
            color: #003366;
            border-radius: 15px;
            transition: background-color 0.4s ease, color 0.4s ease;
            cursor: default;
            box-shadow: 0 4px 15px rgba(0, 64, 128, 0.1);
        }

        .row-cols-1.row-cols-md-3 > .col > div:hover {
            background-color: #004080;
            color: white;
            box-shadow: 0 10px 30px rgba(0, 64, 128, 0.3);
        }

        /* Témoignages */
        section.bg-light .border {
            background: #ffffff;
            border-radius: 20px;
            padding: 25px 30px;
            transition: box-shadow 0.3s ease;
            box-shadow: 0 5px 20px rgba(0, 64, 128, 0.1);

            min-height: 180px; /* même hauteur minimale pour homogénéité */
            display: flex;
            flex-direction: column;
            justify-content: space-between; /* espace entre texte et signature */
            text-align: left; /* texte aligné à gauche pour meilleure lisibilité */

        }

        section.bg-light .border:hover {
            box-shadow: 0 15px 40px rgba(0, 64, 128, 0.2);
        }

        section.bg-light .border p {
            font-style: italic;
            font-size: 1.05rem;
            color: #333;
            margin-bottom: 1rem;
            flex-grow: 1; /* prend tout l’espace possible */
        }

        section.bg-light .border strong {
            margin-top: 15px;
            font-weight: 700;
            color: #003366;
            align-self: flex-end; /* signature alignée à droite */
        }


        /* Call to Action */
        section.py-5.text-center.text-white {
            background: linear-gradient(135deg, #0059b3, #007bff);
            border-radius: 25px;
            padding: 60px 30px;
            box-shadow: 0 8px 35px rgba(0, 123, 255, 0.5);
            max-width: 800px;
            margin: 0 auto 100px auto;
        }

        section.py-5.text-center.text-white h2 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: 1.5px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
        }

        section.py-5.text-center.text-white p {
            font-size: 1.3rem;
            margin-bottom: 3rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .promo-section {
            background: linear-gradient(135deg, #0062cc, #004085);
        }
        .promo-card {
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 12px;
            transition: transform 0.3s ease;
        }
        .promo-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.15);
        }
        .promo-card h4 {
            font-weight: bold;
            margin-bottom: 10px;
        }
        @media (max-width: 768px) {
            .promo-card {
                margin-bottom: 20px; /* espace entre les cartes en responsive */
            }
        }

        .btn-primary {
            background-color: #0066cc;
            border: none;
            font-weight: 700;
            font-size: 1.25rem;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            box-shadow: 0 8px 25px rgba(0, 102, 204, 0.6);
            transition: background-color 0.4s ease, box-shadow 0.4s ease;
        }

        .btn-primary:hover {
            background-color: #004080;
            box-shadow: 0 12px 40px rgba(0, 64, 128, 0.8);
        }

        /* Responsive */
        @media (max-width: 768px) {
            main {
                padding: 40px 15px;
            }

            .section-title {
                font-size: 2.2rem;
            }

            #stats-section h3 {
                font-size: 3rem;
            }

            section.py-5.text-center.text-white {
                padding: 40px 20px;
                border-radius: 15px;
            }

            section.py-5.text-center.text-white h2 {
                font-size: 2.2rem;
            }

            .btn-primary {
                font-size: 1.1rem;
                padding: 0.9rem 2rem;
            }
        }
          /* ===== Bouton flottant attirant ===== */
          .floating-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: linear-gradient(135deg, #FFD700, #FF4500); /* Or → Rouge/Orange */
            color: white;
            padding: 20px 40px;
            border-radius: 50px;
            font-weight: 900;
            font-size: 1.4rem;
            font-family: 'Montserrat', sans-serif;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 10px 30px rgba(255, 69, 0, 0.7),
                        0 0 15px rgba(255, 215, 0, 0.9);
            text-decoration: none;
            z-index: 9999;
            transition: all 0.3s ease;
            animation: pulseGlow 2s infinite, floatY 3s ease-in-out infinite;
        }

        /* Effet hover */
        .floating-btn:hover {
            background: linear-gradient(135deg, #FF8C00, #FF0000);
            transform: scale(1.08) translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 69, 0, 0.9),
                        0 0 25px rgba(255, 215, 0, 1);
        }

        /* Animation pulsation lumineuse */
        @keyframes pulseGlow {
            0%   { box-shadow: 0 10px 30px rgba(255, 69, 0, 0.7), 0 0 15px rgba(255, 215, 0, 0.9); }
            50%  { box-shadow: 0 15px 40px rgba(255, 69, 0, 1), 0 0 30px rgba(255, 215, 0, 1); }
            100% { box-shadow: 0 10px 30px rgba(255, 69, 0, 0.7), 0 0 15px rgba(255, 215, 0, 0.9); }
        }

        /* Animation flottement vertical */
        @keyframes floatY {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(-6px); }
        }

        /* ===== Responsive ===== */
        @media (max-width: 992px) { /* Tablette */
            .floating-btn {
                font-size: 1.2rem;
                padding: 16px 30px;
            }
        }

        @media (max-width: 768px) { /* Mobile */
            .floating-btn {
                font-size: 1rem;
                padding: 14px 25px;
                bottom: 15px;
                right: 15px;
            }
        }

        @media (max-width: 480px) { /* Très petit mobile */
            .floating-btn {
                font-size: 0.95rem;
                padding: 12px 20px;
                border-radius: 40px;
            }
        }
        .admission-steps {
            background: #f9f9f9;
        }

        .section-title {
            font-weight: bold;
        }

        .highlight {
            color: #007bff;
        }

        /* Global progress bar */
        .steps-progress {
            position: relative;
            height: 8px;
            background: #ddd;
            border-radius: 4px;
            overflow: hidden;
            margin-bottom: 40px;
        }

        .progress-fill {
            position: absolute;
            height: 100%;
            width: 0%;
            background: linear-gradient(90deg, #007bff, #00c6ff);
            border-radius: 4px;
            transition: width 1s ease;
        }

        /* Step cards same size */
        .step-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            height: 100%;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            transition: transform 0.4s ease, box-shadow 0.4s ease;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            min-height: 300px;
        }

        .step-icon {
            font-size: 2rem;
            color: #007bff;
        }

        .step-number {
            position: absolute;
            top: -15px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #007bff;
            box-shadow: 0 0 10px rgba(0,123,255,0.4);
            border: 3px solid transparent;
            animation: pulseBorder 2s infinite;
        }

        @keyframes pulseBorder {
            0%, 100% { border-color: rgba(0,123,255,0.2); }
            50% { border-color: rgba(0,123,255,0.8); }
        }

        .step-card.active {
            transform: scale(1.05);
            box-shadow: 0 0 25px rgba(0, 198, 255, 0.6);
        }

        .step-card:hover {
            transform: scale(1.05);
            box-shadow: 0 0 25px rgba(0, 198, 255, 0.6);
        }

        /* Active step number glow */
        .step-number.active {
            background: #007bff;
            color: white;
            box-shadow: 0 0 15px rgba(0, 123, 255, 0.8), 0 0 25px rgba(0, 198, 255, 0.6);
            animation: pulseGlow 1.5s infinite;
        }

        @keyframes pulseGlow {
            0% { box-shadow: 0 0 5px rgba(0,123,255,0.6), 0 0 15px rgba(0,198,255,0.4); }
            50% { box-shadow: 0 0 20px rgba(0,123,255,1), 0 0 35px rgba(0,198,255,0.9); }
            100% { box-shadow: 0 0 5px rgba(0,123,255,0.6), 0 0 15px rgba(0,198,255,0.4); }
        }

        /* Responsive spacing fix */
        @media (max-width: 768px) {
        .admission-steps {
            margin-top: 40px;
        }
        }

        .text-justify {
            text-align: justify;
        }

        /* Justifier le texte */
        .text-justify {
            text-align: justify;
        }

        /* Améliorer la lisibilité des listes */
        ul li {
            margin-bottom: 8px;
            font-size: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            h2.section-title {
            font-size: 1.8rem;
            }
            p.text-muted {
            font-size: 0.95rem;
            }
            ul li {
            font-size: 0.95rem;
            }
        }

    </style>
    <style>
      /* Slider */
        /* Slider */
        .hero-slider, .hero-slider .carousel-inner, .hero-slider .carousel-item {
            height: 80vh;
            min-height: 500px;
        }

        .hero-slider .slide-content {
            position: relative;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* Overlay dynamique */
        .dynamic-overlay {
            position: absolute;
            top:0; left:0;
            width:100%; height:100%;
            background: linear-gradient(135deg, rgba(0,64,128,0.7), rgba(0,102,204,0.6), rgba(0,198,255,0.4));
            animation: gradientShift 12s ease infinite;
            z-index:1;
            backdrop-filter: blur(2px);
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Contenu centré */
        .content-wrapper {
            position: relative;
            z-index: 2;
            max-width: 900px;
            padding: 0 20px;
        }

        /* Animations */
        .animate-slide { animation: slideUp 1s ease-out forwards; }
        .animate-slide-delay { animation: slideUp 1s ease-out 0.5s forwards; }
        @keyframes slideUp {
            0% { transform: translateY(30px); opacity: 0; }
            100% { transform: translateY(0); opacity: 1; }
        }

        /* Highlight texte */
        .highlight { color: #FFD700; text-shadow: 2px 2px 6px rgba(0,0,0,0.6); }
        .hero-slider h1, .hero-slider p { text-shadow: 1px 1px 6px rgba(0,0,0,0.6); }

        /* Boutons animés */
        .animate-btn {
            animation: pulseBtn 2s infinite alternate;
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .animate-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 40px rgba(0,0,0,0.5);
        }
        @keyframes pulseBtn { 0% { transform: scale(1); } 100% { transform: scale(1.05); } }

        /* Institutions grid responsive */
        /* Grid institutions responsive */
        .institutions-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .etab-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative; /* pour positionner les boutons */
            min-width: 80px; /* largeur minimale pour responsive */
        }

        .etab-wrapper span {
            padding: 8px 12px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.2s, background 0.2s;
            text-align: center;
        }

        .etab-wrapper span:hover {
            transform: scale(1.1);
            background: rgba(255,255,255,0.3);
        }

        /* Boutons formations sous chaque span */
        .formation-buttons {
            display: flex;
            gap: 5px;
            margin-top: 5px;
            animation: fadeIn 0.3s ease;
            flex-wrap: wrap; /* pour petits écrans, boutons passent à la ligne */
            justify-content: center;
        }

        .formation-buttons .btn {
            font-size: 0.8rem;
            padding: 4px 8px;
            border-radius: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .formation-buttons .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(5px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .etab-wrapper span {
                font-size: 0.85rem;
                padding: 6px 10px;
            }
            .formation-buttons .btn {
                font-size: 0.75rem;
                padding: 3px 6px;
            }
        }

        @media (max-width: 576px) {
            .etab-wrapper span {
                font-size: 0.8rem;
                padding: 5px 8px;
            }
            .formation-buttons .btn {
                font-size: 0.7rem;
                padding: 3px 5px;
            }
        }


        /* Responsive */
        @media (max-width: 768px) {
            .hero-slider h1 { font-size: 1.8rem; }
            .hero-slider p { font-size: 1rem; }
            .institutions-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 576px) {
            .hero-slider h1 { font-size: 1.5rem; }
            .hero-slider p { font-size: 0.9rem; }
            .institutions-grid { grid-template-columns: repeat(3, 1fr); }
        }

        /* Titres adaptés */
        .main-title {
            font-size: 3.7rem; /* grand écran */
            font-weight: 800;
            margin-bottom: 1rem;
        }
        .sub-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .small-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        /* Grille institutions améliorée */
        .institutions-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* 3 colonnes par défaut */
            gap: 15px;
            justify-items: center;
            margin-bottom: 20px;
        }

        /* Responsive */
        @media (max-width: 992px) {
            .main-title { font-size: 2.4rem; }
            .sub-title { font-size: 1.6rem; }
            .small-title { font-size: 1.3rem; }
            .institutions-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 colonnes tablette */
            }
        }

        @media (max-width: 576px) {
            .main-title { font-size: 1.8rem; }
            .sub-title { font-size: 1.0rem; }
            .small-title { font-size: 0.8rem; }
            .institutions-grid {
                grid-template-columns: repeat(2, 1fr); /* 2 colonnes mobile */
                gap: 10px;
            }
            .etab-wrapper span {
                font-size: 0.8rem;
                padding: 5px 8px;
            }
        }



    </style>



</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="{{ asset('images/logos/uh1-vert-plus.PNG') }}" alt="Université Hassan 1er" />
            </div>
            <ul class="nav-links">
                <li><a href="{{ route('welcome') }}" class="{{ Route::currentRouteNamed('welcome') ? 'active' : '' }}">Accueil</a></li>
                <li><a href="{{ route('nosformation') }}" class="{{ Route::currentRouteNamed('nosformation') ? 'active' : '' }}">Formations</a></li>
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

    <main>
        <!-- Super Attractive Floating Button -->
        <a href="{{ route('preinscription') }}" class="floating-btn">
            🚀 Préinscription
        </a>


        <!-- Hero Slider Premium -->
        <section class="hero-slider position-relative overflow-hidden p-0">
            <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="7000">
                <div class="carousel-inner">

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <div class="slide-content" style="background-image: url('{{ asset('images/Formation-temps-amenage.png') }}')">
                            <div class="dynamic-overlay"></div>
                            <div class="content-wrapper text-center text-white">
                                <h1 class="display-4 fw-bold mb-3 animate-slide">
                                    Bienvenue aux <span class="highlight">Programmes de Formation Initiale à Temps Aménagé</span> de l’Université Hassan Premier
                                </h1>
                                <p class="lead mb-4 animate-slide-delay">
                                    Étudiez tout en travaillant grâce à des programmes diplômants officiels, avec un emploi du temps adapté en soirées et week-ends.
                                </p>
                                <a href="{{ route('nosformation') }}" class="btn btn-primary btn-lg shadow-lg animate-btn">
                                    Découvrir nos formations
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <div class="slide-content" style="background-image: url('{{ asset('images/Formation-temps-amenage.png') }}')">
                            <div class="dynamic-overlay"></div>
                            <div class="content-wrapper text-center text-white">

                                <!-- Grand titre -->
                                <h1 class="main-title animate-slide">
                                    <span class="highlight">FORMATION INITIALE À TEMPS AMÉNAGÉ</span>
                                </h1>

                                <!-- Titre secondaire -->
                                <h2 class="sub-title animate-slide">
                                    <span>Licences et Masters Universitaires Nationaux</span>
                                </h2>

                                <!-- Sous-titre -->
                                <h3 class="small-title animate-slide highlight">
                                    Ouverture d’Inscriptions 2025/2026
                                </h3>

                                <!-- Texte -->
                                <p class="lead mb-4 animate-slide-delay">
                                    L’Université Hassan 1er informe les étudiants et les professionnels de l’ouverture des inscriptions 
                                    en licences et masters universitaires en <strong>temps aménagé</strong> pour l’année universitaire 2025-2026, 
                                    avec des cours organisés en <strong>soirées et week-ends</strong>, permettant de concilier études et activité professionnelle.
                                </p>

                                <!-- Institutions responsive grid -->
                                 <div class="institutions-grid">
                                    <div class="etab-wrapper"><span data-id="8">🎭 FLASH</span></div>
                                    <div class="etab-wrapper"><span data-id="2">💼 ENCG</span></div>
                                    <div class="etab-wrapper"><span data-id="4">⚙️ ENSA</span></div>
                                    <div class="etab-wrapper"><span data-id="1">⚖️ FSJP</span></div>
                                    <div class="etab-wrapper"><span data-id="7">📚 ESEF</span></div>
                                    <div class="etab-wrapper"><span data-id="3">🔬 FST</span></div>
                                    <div class="etab-wrapper"><span data-id="5">🩺 I3S</span></div>
                                    <div class="etab-wrapper"><span data-id="6">🏃‍♂️ ISS</span></div>
                                    <div class="etab-wrapper"><span data-id="9">📊 FEG</span></div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- Controls -->
                <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"></span>
                    <span class="visually-hidden">Précédent</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon bg-dark rounded-circle p-3"></span>
                    <span class="visually-hidden">Suivant</span>
                </button>
            </div>
        </section>




        <!-- Introduction Temps Aménagé -->
        <section class="py-5 bg-light">
            <div class="container">
                <!-- Titre et introduction -->
                <div class="text-center mb-4">
                <h2 class="section-title fw-bold">
                    Des études supérieures adaptées à votre rythme et à vos ambitions
                </h2>
                <p class="text-muted mt-3 text-justify">
                    L’Université Hassan 1er met à votre disposition un dispositif de <strong>formation diplômante en temps aménagé</strong>,
                    spécialement conçu pour les professionnels, les salariés, les fonctionnaires et toute personne souhaitant poursuivre ses
                    études tout en conciliant <strong>vie professionnelle, personnelle et académique</strong>.
                    <br>
                    Grâce à des <strong>emplois du temps flexibles</strong> (cours en soirées et/ou week-ends) et un encadrement de qualité assuré
                    par des enseignants-chercheurs expérimentés, le temps aménagé vous permet d’acquérir un diplôme national reconnu, sans
                    interrompre votre carrière ni vos engagements personnels.
                </p>
                </div>

                <!-- Phrase avant domaines -->
                <div class="text-justify mb-3">
                <p class="fw-semibold">
                    Les domaines de formation proposés en temps aménagé couvrent un large éventail de disciplines modernes et porteuses :
                </p>
                </div>

                <!-- Domaines de formation -->
                <div class="row text-start">
                <div class="col-md-6 mb-3">
                    <ul class="list-unstyled">
                    <li>⚡ Sciences et Techniques Industrielles</li>
                    <li>🤖 Informatique, Digitalisation et Intelligence Artificielle</li>
                    <li>📡 Réseaux, Télécommunications et Cybersécurité</li>
                    <li>🌱 Environnement, Énergies Renouvelables et Développement Durable</li>
                    <li>💼 Gestion, Administration et Entrepreneuriat</li>
                    <li>💰 Finance, Comptabilité, Audit et Contrôle de Gestion</li>
                    <li>📊 Management de Projet, Stratégie et Leadership</li>
                    </ul>
                </div>

                <div class="col-md-6 mb-3">
                    <ul class="list-unstyled">
                    <li>🚀 Innovation, Transformation Digitale et Systèmes d’Information</li>
                    <li>👥 Gestion des Ressources Humaines et Ingénierie des Compétences</li>
                    <li>📘 Sciences de l’Éducation, Ingénierie Pédagogique et Formation</li>
                    <li>✅ Qualité, Sécurité, Environnement et Amélioration Continue</li>
                    <li>🛡 Prévention, Sécurité au Travail et Gestion des Risques</li>
                    <li>🏃 Sciences du Sport, Santé et Performance Physique</li>
                    <li>📚 Droit, Administration, Management et Ingénierie des Systèmes</li>
                    </ul>
                </div>
                </div>

                <!-- Conclusion -->
                <div class="text-center mt-4">
                <p class="fw-bold text-primary fs-5">
                    Avec le dispositif du Temps Aménagé de l’Université Hassan 1er, réalisez vos ambitions académiques sans sacrifier votre équilibre professionnel et personnel.
                </p>
                </div>
            </div>
        </section>



        <!-- Nouvelle Section Promotion -->
        <section class="py-5 bg-primary text-white promo-section">
            <div class="container">
                <div class="text-center mb-4">
                    <h2 class="fw-bold">Boostez votre avenir académique avec nos formations à temps aménagé</h2>
                    <p class="lead">
                        Grâce à des programmes flexibles et adaptés aux étudiants actifs, l’Université Hassan 1er propose des parcours initiaux à temps aménagé, conçus pour concilier études et obligations professionnelles ou personnelles. Ces formations vous permettent de développer vos compétences, approfondir vos connaissances et construire un projet académique solide, favorisant la <strong style="color: #ff8c02;">réussite universitaire</strong>, la <strong style="color: #ff8c02;">progression personnelle</strong>, et l’accès à un <strong style="color: #ff8c02;">avenir professionnel prometteur</strong>.
                    </p>
                </div>
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="promo-card">
                            <h4>📚 Flexibilité académique</h4>
                            <p>Organisez vos études selon votre emploi du temps et vos contraintes personnelles.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="promo-card">
                            <h4>🎯 Excellence pédagogique</h4>
                            <p>Bénéficiez d’un encadrement académique de qualité et d’un suivi personnalisé.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="promo-card">
                            <h4>🚀 Opportunités futures</h4>
                            <p>Préparez-vous à intégrer le marché du travail avec un profil compétitif et polyvalent.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Chiffres clés -->
        <section class="py-5 text-center" id="stats-section">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <h3 class="fw-bold text-primary" data-target="30000">0</h3>
                        <p class="text-muted">Diplômés en formation initiale à Temps Aménagé</p>
                    </div>
                    <div class="col-md-4">
                        <h3 class="fw-bold text-primary" data-target="95">0%</h3>
                        <p class="text-muted">Taux de satisfaction</p>
                    </div>
                    <div class="col-md-4">
                        <h3 class="fw-bold text-primary" data-target="90">0</h3>
                        <p class="text-muted">Programmes disponibles</p>
                    </div>
                </div>
            </div>
        </section>

       
        <!-- Avantages -->
        <section class="py-5 bg-light" id="formations">
            <div class="container">
                <h2 class="section-title text-center mb-5">Nos points forts</h2>
                <div class="row text-center g-4">

                    <!-- Carte 1 -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm p-4">
                            <i class="fas fa-briefcase fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Opportunités académiques et professionnelles</h5>
                            <p class="card-text text-muted">Un programme conçu pour préparer efficacement les étudiants à la fois aux études et au marché du travail.</p>
                        </div>
                    </div>

                    <!-- Carte 2 -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm p-4">
                            <i class="fas fa-user-graduate fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Encadrement de qualité</h5>
                            <p class="card-text text-muted">Des enseignants expérimentés assurent un suivi personnalisé pour garantir la réussite de chaque étudiant.</p>
                        </div>
                    </div>

                    <!-- Carte 3 -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm p-4">
                            <i class="fas fa-globe fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Développement de compétences</h5>
                            <p class="card-text text-muted">Acquérez des compétences pratiques et théoriques adaptées aux exigences actuelles de votre domaine.</p>
                        </div>
                    </div>

                    <!-- Carte 4 -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm p-4">
                            <i class="fas fa-book fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Programme enrichissant</h5>
                            <p class="card-text text-muted">Des cours et ateliers conçus pour approfondir vos connaissances et favoriser la réussite académique.</p>
                        </div>
                    </div>

                    <!-- Carte 5 -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm p-4">
                            <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Horaires flexibles</h5>
                            <p class="card-text text-muted">Suivez vos cours à temps aménagé pour concilier études, travail et obligations personnelles.</p>
                        </div>
                    </div>

                    <!-- Carte 6 -->
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm p-4">
                            <i class="fas fa-lightbulb fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">Épanouissement personnel</h5>
                            <p class="card-text text-muted">Une formation à temps aménagé pour développer vos compétences, votre autonomie et votre confiance.</p>
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <!-- Domaines -->
        <section class="py-5">
            <div class="container text-center">
                <h2 class="section-title mb-5">Domaines de formation à temps aménagé</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <div class="p-4 border rounded shadow-sm">
                            ⚡ Sciences & Techniques Industrielles
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-4 border rounded shadow-sm">
                            🤖 Informatique, Digitalisation & Intelligence Artificielle
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-4 border rounded shadow-sm">
                            📡 Réseaux, Télécommunications & Cybersécurité
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-4 border rounded shadow-sm">
                            💼 Gestion, Commerce & Management
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-4 border rounded shadow-sm">
                            🏥 Santé, Paramédical & Sciences du Sport
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-4 border rounded shadow-sm">
                            📘 Éducation, Ingénierie Pédagogique & Formation
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-4 border rounded shadow-sm">
                            🌱 Environnement, Énergies Renouvelables & Développement Durable
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-4 border rounded shadow-sm">
                            🛡 Droit, Gouvernance & Sécurité
                        </div>
                    </div>
                    <div class="col">
                        <div class="p-4 border rounded shadow-sm">
                            💡 Innovation, Marketing & Stratégie d’Entreprise
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Témoignages -->
        <section class="py-5 bg-light">
            <div class="container text-center">
                <h2 class="section-title mb-5">Ils témoignent</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="p-4 border rounded shadow-sm">
                            <p class="text-muted">"Grâce au programme à temps aménagé, j’ai pu poursuivre mes études en conciliant mon emploi tout en suivant un cursus enrichissant."</p>
                            <strong>- Amina, étudiante FSJP</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 border rounded shadow-sm">
                            <p class="text-muted">"Le programme est parfaitement adapté pour gérer travail et études. J’ai acquis des compétences très utiles pour ma carrière."</p>
                            <strong>- Karim, étudiant FEG</strong>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 border rounded shadow-sm">
                            <p class="text-muted">"Cette formation à temps aménagé m’a permis d’approfondir mes connaissances et de progresser tout en respectant mon emploi du temps."</p>
                            <strong>- Salma, étudiante FST</strong>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <!-- Section : Comment intégrer nos formations -->
        <section class="admission-steps py-5">
            <div class="container">
                <h2 class="section-title text-center mb-5">
                    🎓 Comment intégrer nos <span class="highlight">Formations Initiales à Temps Aménagé</span> :
                    Masters & Licences Universitaires Professionnels
                </h2>

                <!-- Barre de progression globale -->
                <div class="steps-progress">
                    <div class="progress-fill"></div>
                </div>

                <div class="row g-4 justify-content-center">
                    <!-- Step 1 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="step-card" data-step="1">
                            <div class="step-number"><span>1</span></div>
                            <div class="step-icon"><i class="fas fa-laptop"></i></div>
                            <h4>Inscription en ligne</h4>
                            <p>Remplissez le formulaire d'inscription en ligne pour débuter votre candidature.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="step-card" data-step="2">
                            <div class="step-number"><span>2</span></div>
                            <div class="step-icon"><i class="fas fa-search"></i></div>
                            <h4>Préselection</h4>
                            <p>Le dossier est examiné pour déterminer la présélection des candidats admissibles.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="step-card" data-step="3">
                            <div class="step-number"><span>3</span></div>
                            <div class="step-icon"><i class="fas fa-clipboard-check"></i></div>
                            <h4>Admission</h4>
                            <p>Les candidats présélectionnés passent un test ou entretien d'admission.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="col-md-3 col-sm-6">
                        <div class="step-card" data-step="4">
                            <div class="step-number"><span>4</span></div>
                            <div class="step-icon"><i class="fas fa-file-signature"></i></div>
                            <h4>Inscription définitive</h4>
                            <p>Complétez les formalités finales : dépôt du dossier physique et versement de la première tranche.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>





        <!-- Call to Action -->
        <section class="py-5 text-center text-white" style="background: linear-gradient(135deg, #0059b3, #007bff); border-radius: 25px; box-shadow: 0 8px 35px rgba(0, 123, 255, 0.5); max-width: 2000px; margin: 0 auto 100px auto;">
            <div class="container">
                <h2 class="mb-3">Votre avenir à temps aménagé commence ici</h2>
                <p class="mb-4">
                    Faites votre préinscription dès aujourd’hui et rejoignez nos formations initiales à temps aménagé pour suivre vos études tout en conciliant vos activités.
                </p>
                <a
                    href="{{ route('preinscription') }}"
                    class="btn btn-primary btn-lg px-4 py-3 shadow"
                    style="border-radius: 50px; font-weight: bold;"
                >
                    🚀 Je fais ma préinscription maintenant
                </a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sections = document.querySelectorAll('main section');

            function checkVisibleSections() {
                const windowBottom = window.scrollY + window.innerHeight;
                sections.forEach((section) => {
                    const sectionTop = section.offsetTop;
                    if (windowBottom > sectionTop + 100) {
                        section.classList.add('visible');
                    }
                });
            }

            window.addEventListener('scroll', checkVisibleSections);
            checkVisibleSections();
        });

        document.addEventListener('DOMContentLoaded', function () {
            const statsSection = document.getElementById('stats-section');
            const counters = statsSection.querySelectorAll('h3[data-target]');
            let hasAnimated = false;

            function animateCounters() {
                const windowBottom = window.scrollY + window.innerHeight;
                const sectionTop = statsSection.offsetTop;

                if (!hasAnimated && windowBottom > sectionTop + 100) {
                    counters.forEach((counter) => {
                        const targetStr = counter.getAttribute('data-target');
                        const isPercent = counter.textContent.includes('%');
                        const target = parseInt(targetStr, 10);

                        let count = 0;
                        const increment = Math.ceil(target / 100);
                        const duration = 2000;
                        const intervalTime = Math.floor(duration / (target / increment));

                        const interval = setInterval(() => {
                            count += increment;
                            if (count >= target) {
                                count = target;
                                clearInterval(interval);
                            }
                            counter.textContent = isPercent ? count + '%' : count;
                        }, intervalTime);
                    });
                    hasAnimated = true;
                }
            }

            window.addEventListener('scroll', animateCounters);
            animateCounters();
        });
    </script>
    <script>
        let currentStep = 1;
        const totalSteps = 4;
        const stepCards = document.querySelectorAll('.step-card');
        const stepNumbers = document.querySelectorAll('.step-number');
        const progressFill = document.querySelector('.progress-fill');

        function highlightStep(step) {
            stepCards.forEach(card => card.classList.remove('active'));
            stepNumbers.forEach(num => num.classList.remove('active'));

            const activeCard = document.querySelector(`.step-card[data-step="${step}"]`);
            const activeNumber = activeCard.querySelector('.step-number');

            if (activeCard) activeCard.classList.add('active');
            if (activeNumber) activeNumber.classList.add('active');

            progressFill.style.width = (step / totalSteps) * 100 + "%";
        }

        // Auto cycle steps
        setInterval(() => {
            highlightStep(currentStep);
            currentStep = currentStep % totalSteps + 1;
        }, 2000);

        // First highlight
        highlightStep(currentStep);

    </script>
    <script>
        document.querySelectorAll('.etab-wrapper span').forEach(span => {
                span.addEventListener('click', () => {
                    const wrapper = span.parentElement;

                    // Supprimer anciens boutons
                    document.querySelectorAll('.formation-buttons').forEach(el => el.remove());

                    // Créer les boutons
                    const btnBox = document.createElement('div');
                    btnBox.classList.add('formation-buttons');
                    const etabId = span.getAttribute('data-id');
                    btnBox.innerHTML = `
                        <a href="/nos-formation/${etabId}/licence" class="btn btn-outline-light">🎓 Licence</a>
                        <a href="/nos-formation/${etabId}/master" class="btn btn-primary">🎓 Master</a>
                    `;

                    // Ajouter les boutons dans le wrapper
                    wrapper.appendChild(btnBox);

                    // Animation : faire “remonter” le span entre les deux boutons
                    span.style.marginBottom = '5px';
                });
            });

    </script>

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function () {
            const etabs = document.querySelectorAll(".institutions-grid span");
            const btnsContainer = document.getElementById("formation-buttons");
            const btnLicence = document.getElementById("btn-licence");
            const btnMaster = document.getElementById("btn-master");

            etabs.forEach(etab => {
                etab.addEventListener("click", () => {
                    const id = etab.getAttribute("data-id");

                    // Génération des liens dynamiques
                    btnLicence.href = `/nos-formation/${id}/licence`;
                    btnMaster.href = `/nos-formation/${id}/master`;

                    // Affiche les boutons joliment
                    btnsContainer.classList.remove("hidden");
                    btnsContainer.scrollIntoView({ behavior: "smooth", block: "center" });
                });
            });
        });
    </script> --}}

</body>
</html>
