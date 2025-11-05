<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Université Hassan 1er - Nos Formations</title>
    <link rel="stylesheet" href="{{ asset('css/styles-welcomeLEM.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="{{ asset('images/favicon-uh1.png') }}" type="image/x-icon">
    <style>
        /* === Modal Base === */
        .licence-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-in-out;
        }

        /* === Modal Content === */
        .licence-modal-content {
            background: linear-gradient(145deg, #ffffff, #f5f7fa);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
            text-align: center;
            padding: 40px;
            width: 90%;
            max-width: 450px;
            position: relative;
            animation: slideUp 0.5s ease forwards;
            border: 1px solid rgba(0,0,0,0.05);
        }

        /* === Modal Text === */
        .modal-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #0b3d2e;
            margin-bottom: 10px;
        }

        .modal-subtitle {
            color: #555;
            margin-bottom: 30px;
        }

        /* === Close Button === */
        .close-btn {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            cursor: pointer;
            color: #333;
            transition: transform 0.2s ease;
        }
        .close-btn:hover {
            transform: scale(1.2);
            color: #0b8457;
        }

        /* === Buttons === */
        .modal-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .magic-btn {
            text-decoration: none;
            color: #fff;
            padding: 14px 32px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            cursor: pointer;
        }

        .magic-btn::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at top left, rgba(255,255,255,0.4), transparent);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .magic-btn:hover::before {
            opacity: 1;
        }

        .s1-btn {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            box-shadow: 0 5px 15px rgba(0,176,155,0.4);
        }
        .s5-btn {
            background: linear-gradient(135deg, #007adf, #00ecbc);
            box-shadow: 0 5px 15px rgba(0,122,223,0.4);
        }

        .magic-btn:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.2);
        }

        /* === Animations === */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(40px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>

<body>
<header>
    <nav>
        <div class="logo">
            <img src="{{ asset('images/logos/uh1-vert-plus.PNG') }}" alt="Université Hassan 1er">
        </div>
        <ul class="nav-links">
            <li><a href="{{ route('welcome') }}" class="{{ Route::currentRouteNamed('welcome') ? 'active' : '' }}">Accueil</a></li>
            <li><a href="{{ route('nosformation') }}" class="{{ Route::currentRouteNamed('nosformation') ? 'active' : '' }}">Formations</a></li>
            <li><a href="{{ route('contact') }}" class="{{ Route::currentRouteNamed('contact') ? 'active' : '' }}">Contact</a></li>
            <li><a href="{{ route('login') }}">Connexion</a></li>
        </ul>
        <div class="menu-toggle">
            <span></span><span></span><span></span>
        </div>
    </nav>
</header>

<main>
    <!-- Hero Banner -->
    <div class="hero-banner">
        <h1>Boostez votre carrière avec nos formations initiales à Temps Aménagé</h1>
        <p>Développez vos compétences, maîtrisez les technologies et devenez un acteur clé dans votre domaine.</p>
    </div>

    <section id="establishments">
        <h2>Nos Établissements</h2>
        <div class="establishment-list">
            @foreach ($etablissements as $etablissement)
                <div class="establishment">
                    <img src="{{ asset($etablissement->logo) }}" alt="{{ $etablissement->nom_abrev }} Logo">
                    <h3>{{ $etablissement->nom_abrev }}</h3>
                    <p>{{ $etablissement->nom }}</p>
                    <div class="btn-container">
                        <a href="{{ route('formationMaster', ['etablissement' => $etablissement->id]) }}" class="btn master">Masters</a>
                        <a href="#" class="btn licence" onclick="openLicenceModal(event, '{{ route('formationBachelier', ['etablissement' => $etablissement->id]) }}', '{{ route('formationLicence', ['etablissement' => $etablissement->id]) }}')">Licences</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="university-location" class="location-section">
        <div class="map-wrapper">
            <h2 class="section-title">Où nous trouver ?</h2>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3345.1411167337183!2d-7.618256273714195!3d33.02641247119802!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xda605005a9a375f%3A0x600b2dc95200c14e!2zVW5pdmVyc2l0w6kgSGFzc2FuIDFwcmVzaWRlbmNlINis2KfZhdi52Kkg2KfZhNit2LPZhiDYp9mE2KfZiNmEINiz2LfYp9iqINin2YTYsdim2KfYs9ip!5e0!3m2!1sen!2sma!4v1733230815264!5m2!1sen!2sma"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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

<!-- Licence Modal -->
<div id="licenceModal" class="licence-modal">
    <div class="licence-modal-content">
        <span class="close-btn" onclick="closeLicenceModal()">&times;</span>
        <h2 class="modal-title">Choisissez votre accès</h2>
        <p class="modal-subtitle">Veuillez sélectionner le type de licence que vous souhaitez consulter</p>
        <div class="modal-buttons">
            <a id="accessS1" class="magic-btn s1-btn" href="#">Accès S1</a>
            <a id="accessS5" class="magic-btn s5-btn" href="#">Accès S5</a>
        </div>
    </div>
</div>

<script src="{{ asset('js/script.js') }}"></script>
<script>
    function openLicenceModal(event, s1Route, s5Route) {
        event.preventDefault();
        const modal = document.getElementById('licenceModal');
        modal.style.display = 'flex';
        document.getElementById('accessS1').href = s1Route;
        document.getElementById('accessS5').href = s5Route;
    }

    function closeLicenceModal() {
        document.getElementById('licenceModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('licenceModal');
        if (event.target === modal) closeLicenceModal();
    };
</script>
</body>
</html>
