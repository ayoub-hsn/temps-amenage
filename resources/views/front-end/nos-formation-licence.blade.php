<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Université Hassan 1er - LicencesFormation Initiale en Temps Aménagé</title>
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<link rel="stylesheet" href="{{ asset('css/style-welcome.css') }}" />
<link rel="icon" href="{{ asset('images/favicon-uh1.png') }}" type="image/x-icon">
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

    /* ======= Button Styles ======= */
    .btn-desc {
        display: inline-block;
        width: 209px;               /* fixed width */
        height: 50px;               /* fixed height */
        line-height: 45px;          /* vertically center text */
        font-weight: 600;
        font-size: 0.95rem;
        border-radius: 25px;
        border: none;
        text-decoration: none;
        color: #fff;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: linear-gradient(90deg, #0056b3, #00a1d4);
        box-shadow: 0 4px 15px rgba(255, 180, 0, 0.3);

    
    }

    .btn-desc:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 25px rgba(0, 114, 255, 0.6);
        background: linear-gradient(90deg, #0056b3, #00a1d4);
    }

    @media (max-width: 768px) {
        .btn-desc {
            width: 172px;               /* fixed width */
            height: 45px; 
        }
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
<style>
    .date-banner-container {
        position: fixed;
        bottom: 20px;           /* distance from bottom */
        left: 0;
        right: 0;
        margin: 0 auto;         /* centers horizontally */
        z-index: 999;
        display: flex;
        justify-content: center;
        pointer-events: auto;
        animation: fadeInUp 1.2s ease;
        max-width: 95%;
        opacity: 0;             /* hide initially for smooth fade-in */
    }

    .date-banner-container.loaded {
        opacity: 1;
        transition: opacity 0.5s ease;
    }



    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(25px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .date-banner {
        display: flex;
        align-items: center;
        gap: 18px;
        background: linear-gradient(90deg, rgba(0,70,180,0.95), rgba(0,160,255,0.9), rgba(255,200,0,0.9));
        color: #fff;
        padding: 14px 28px;
        border-radius: 50px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.5), 0 0 35px rgba(0,150,255,0.6);
        font-size: 1.05rem;
        position: relative;
        overflow: hidden;
        text-shadow: 0 0 12px rgba(0,0,0,0.25);
        transition: all 0.3s ease-in-out;
    }




    .date-banner::before {
        content: "";
        position: absolute;
        inset: 0;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.35), transparent);
        animation: bannerShine 5s linear infinite;
    }

    @keyframes bannerShine {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .banner-icon {
        font-size: 1.8rem;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.15); opacity: 0.9; }
    }

    .banner-content strong {
        font-size: 1.1rem;
        letter-spacing: 0.5px;
    }

    .countdown {
        display: inline-block;
        margin-left: 15px;
        background: rgba(255,255,255,0.15);
        padding: 5px 15px;
        border-radius: 20px;
        font-weight: 600;
        color: #fff;
        font-size: 1rem;
        box-shadow: 0 0 15px rgba(255,255,255,0.25);
        transition: all 0.4s ease;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .date-banner {
            padding: 12px 20px;
            font-size: 0.95rem;
            border-radius: 35px;
        }
        .banner-icon {
            font-size: 1.5rem;
        }
        .countdown {
            font-size: 0.9rem;
            padding: 4px 10px;
        }
    }


</style>
<style>
    /* ===== Modern Modal for Missing Descriptif ===== */
    .custom-modal {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.65);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 2000;
        animation: fadeIn 0.3s ease forwards;
    }

    .modal-content {
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(20px);
        border-radius: 25px;
        padding: 40px 35px;
        color: #fff;
        text-align: center;
        max-width: 400px;
        width: 90%;
        box-shadow: 0 10px 45px rgba(0,0,0,0.4);
        animation: popUp 0.4s ease forwards;
    }

    .modal-content h4 {
        font-weight: 700;
        font-size: 1.4rem;
        margin-bottom: 15px;
        color: #ffcc00;
    }

    .modal-content p {
        font-size: 1rem;
        margin-bottom: 20px;
        line-height: 1.5;
    }

    .modal-content button {
        background: linear-gradient(90deg, #ff8c00, #ffb300);
        border: none;
        color: #fff;
        padding: 10px 24px;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .modal-content button:hover {
        transform: scale(1.08);
        box-shadow: 0 0 25px rgba(255,200,0,0.6);
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes popUp {
        from { transform: scale(0.8); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
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
    @if(isset($calendrier))
        <div class="date-banner-container">
            <div class="date-banner">
                <div class="banner-icon"><i class="fas fa-calendar-day"></i></div>
                <div class="banner-content">
                    <strong>📢 Période d’inscription Licence (Accès S5) :</strong>
                    <span class="start-date">
                        {{ \Carbon\Carbon::parse($calendrier->date_debut_passerelle )->translatedFormat('d F Y à H:i') }}
                    </span>
                    <span> — </span>
                    <span class="end-date">
                        {{ \Carbon\Carbon::parse($calendrier->date_fin_passerelle )->translatedFormat('d F Y à H:i') }}
                    </span>
                    <div class="countdown" id="countdown"></div>
                </div>
            </div>
        </div>
    @endif




    <div class="welcome-section text-center">
        <div class="etablissement-logo-container">
            <img src="{{ asset($etablissement->logo) }}" alt="Logo {{ $etablissement->nom }}" class="etablissement-logo">
        </div>
        <h1 class="display-4 fw-bold">
            <span class="highlight">{{ $etablissement->nom }}</span>
        </h1>
        <h2 class="etablissement-name">Formation Initiale en Temps Aménagé</h2>
        <p class="lead mt-3 mb-5">
            Licences (Accès S5)
        </p>
    </div>

    
    <!-- Cartes des formations -->
    <section id="formations" class="formations-list">
        <div class="cards-container">
            @forelse($filieresLicence as $filiere)
                <div class="formation-card">
                    <span class="card-badge">Licence</span>
                    <span class="filiere-code">{{ $filiere->nom_abrv }}</span>
                    <h3 class="filiere-title">{{ $filiere->nom_complet }}</h3>

                    <div class="d-flex flex-column gap-3 align-items-center">
                        @if($filiere->document)
                            <a href="{{ asset($filiere->document) }}" target="_blank" class="btn-description btn-desc">📘 Voir le descriptif</a>
                        @else
                            <button class="btn-description no-doc btn-desc" data-filiere="{{ $filiere->nom_complet }}">📘 Voir le descriptif</button>
                        @endif

                        <a href="{{ route('licence.nosformationChoisen', ['id' => $filiere->id]) }}" class="btn-preinscription">
                            📥 Préinscription
                        </a>
                    </div>
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
    <p>&copy; 2025 Made By Ayoub Hassnioui. Tous droits réservés.</p>
    <div class="social-links">
        <a href="https://www.instagram.com/universitehassan/" target="_blank"><i class="fab fa-instagram"></i></a>
        <a href="https://www.facebook.com/uh1" target="_blank"><i class="fab fa-facebook"></i></a>
        <a href="https://twitter.com/uh1" target="_blank"><i class="fab fa-twitter"></i></a>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const bannerContainer = document.querySelector('.date-banner-container');
        const countdownEl = document.getElementById('countdown');

        if (bannerContainer) bannerContainer.classList.add('loaded');

        const startDateStr = "{{ $calendrier->date_debut_passerelle  ?? '' }}";
        const endDateStr = "{{ $calendrier->date_fin_passerelle  ?? '' }}";

        function updateCountdown() {
            if (!startDateStr || !endDateStr) {
                countdownEl.innerHTML = "⛔ La session de préinscription est terminée";
                countdownEl.style.background = "rgba(255,0,0,0.35)";
                countdownEl.style.boxShadow = "0 0 20px rgba(255,0,0,0.6)";
                return;
            }

            const now = new Date().getTime();
            const startTime = new Date(startDateStr).getTime();
            const endTime = new Date(endDateStr).getTime();

            if (isNaN(startTime) || isNaN(endTime)) {
                countdownEl.innerHTML = "⛔ La session de préinscription est terminée";
                countdownEl.style.background = "rgba(255,0,0,0.35)";
                countdownEl.style.boxShadow = "0 0 20px rgba(255,0,0,0.6)";
                return;
            }

            if (now < startTime) {
                countdownEl.innerHTML = "📅 À venir";
                countdownEl.style.background = "rgba(0,150,255,0.35)";
                countdownEl.style.boxShadow = "0 0 20px rgba(0,150,255,0.6)";
                return;
            }

            const distance = endTime - now;

            if (distance <= 0) {
                countdownEl.innerHTML = "⛔ Fermé";
                countdownEl.style.background = "rgba(255,0,0,0.35)";
                countdownEl.style.boxShadow = "0 0 20px rgba(255,0,0,0.6)";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (days >= 1) {
                countdownEl.innerHTML = `⏳ ${days} j ${hours} h ${minutes} min`;
                countdownEl.style.background = "rgba(255,255,255,0.15)";
                countdownEl.style.boxShadow = "0 0 15px rgba(255,255,255,0.25)";
            } else {
                countdownEl.innerHTML = `🔥 ${hours} h ${minutes} min ${seconds} s`;
                countdownEl.style.background = "rgba(255,150,0,0.4)";
                countdownEl.style.boxShadow = "0 0 20px rgba(255,150,0,0.6)";
            }
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.no-doc').forEach(btn => {
            btn.addEventListener('click', () => {
                const filiereName = btn.getAttribute('data-filiere');

                // Create modal container
                const modal = document.createElement('div');
                modal.classList.add('custom-modal');
                modal.innerHTML = `
                    <div class="modal-content">
                        <h4>📄 Descriptif non disponible</h4>
                        <p>Le descriptif de la filière <strong>${filiereName}</strong> n’est pas disponible pour le moment.</p>
                        <button>Fermer</button>
                    </div>
                `;

                // Add modal to page
                document.body.appendChild(modal);

                // Close on button or outside click
                const closeModal = () => modal.remove();
                modal.querySelector('button').addEventListener('click', closeModal);
                modal.addEventListener('click', e => { if (e.target === modal) closeModal(); });
            });
        });
    });
</script>
</body>
</html>
