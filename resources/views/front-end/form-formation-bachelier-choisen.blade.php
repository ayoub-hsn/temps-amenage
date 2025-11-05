@extends('front-end.layouts.master')

@section('content')
<style>
    #app {
        margin-top: 3%;
    }

    .ended-section {
        background: linear-gradient(135deg, #002b5c, #004B87, #007ACC);
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        position: relative;
        color: white;
        padding: 80px 20px;
        overflow: hidden;
        perspective: 1000px;
    }

    .ended-section::before,
    .ended-section::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 215, 0, 0.18), transparent 70%);
        animation: floatOrbs 10s ease-in-out infinite alternate;
        z-index: 0;
    }

    .ended-section::before {
        top: -150px;
        left: -120px;
        width: 420px;
        height: 420px;
    }

    .ended-section::after {
        bottom: -180px;
        right: -160px;
        width: 480px;
        height: 480px;
        animation-delay: 3s;
    }

    @keyframes floatOrbs {
        from { transform: translateY(0) scale(1); opacity: 0.9; }
        to { transform: translateY(25px) scale(1.1); opacity: 1; }
    }

    .ended-card {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(18px);
        border-radius: 35px;
        padding: 70px 50px;
        max-width: 780px;
        width: 100%;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        animation: fadeInUp 1.3s ease forwards;
        position: relative;
        z-index: 2;
        border: 1px solid rgba(255, 255, 255, 0.15);
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(50px) rotateX(5deg); }
        to { opacity: 1; transform: translateY(0) rotateX(0); }
    }

    /* ====== LOGO WITH BACKGROUND ====== */
    .logo-container {
        position: relative;
        display: inline-block;
        margin-bottom: 30px;
    }

    .logo-bg {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 150px;
        height: 150px;
        background: radial-gradient(circle at center, #FFD700 0%, #FFC107 40%, rgba(255, 215, 0, 0.2) 100%);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
        filter: blur(8px);
        animation: pulseGlow 3s ease-in-out infinite alternate;
    }

    @keyframes pulseGlow {
        from { transform: translate(-50%, -50%) scale(1); opacity: 0.9; }
        to { transform: translate(-50%, -50%) scale(1.1); opacity: 0.7; }
    }

    .univ-logo {
        position: relative;
        width: 110px;
        height: auto;
        z-index: 2;
        animation: floatLogo 4s ease-in-out infinite alternate;
        filter: drop-shadow(0 0 10px rgba(255, 215, 0, 0.3));
    }

    @keyframes floatLogo {
        from { transform: translateY(0); }
        to { transform: translateY(-10px); }
    }

    .ended-card h2 {
        font-size: 2.5em;
        font-weight: 800;
        margin-bottom: 20px;
        color: #FFD700;
        text-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
    }

    .ended-card p {
        font-size: 1.25em;
        line-height: 1.8;
        color: #f1f1f1;
        margin-bottom: 40px;
    }

    .btn-retour {
        background: linear-gradient(90deg, #FFD700, #FFC107);
        color: #002b5c;
        padding: 15px 38px;
        font-weight: 700;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 1.1em;
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        display: inline-block;
    }

    .btn-retour:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 25px rgba(255, 215, 0, 0.6);
    }

    section.hero {
        background: linear-gradient(to right, #004B87, #0066b3);
        color: white;
        padding: 80px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    section.hero h2 {
        font-size: 2.8em;
        font-weight: 800;
        margin-bottom: 20px;
    }

    section.hero p {
        font-size: 1.3em;
        line-height: 1.7;
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .ended-card {
            padding: 45px 25px;
        }

        .ended-card h2 {
            font-size: 2em;
        }

        .ended-card p {
            font-size: 1.05em;
        }

        .logo-bg {
            width: 120px;
            height: 120px;
        }
    }
</style>

<!-- Section d'accueil -->
<section style="background: linear-gradient(to right, #004B87, #0066b3); color: white; padding: 60px 20px;">
    <div style="max-width: 1100px; margin: auto; text-align: center;">
        <h2 style="font-size: 2.5em; font-weight: bold; margin-bottom: 20px;">
            🎓 Bienvenue à l’Université Hassan 1er
        </h2>
        <p style="font-size: 1.2em; margin-bottom: 40px; line-height: 1.6;">
            Rejoignez une université moderne qui allie excellence académique, innovation et ouverture sur le monde.
            Nos programmes sont conçus pour vous préparer à un avenir brillant et plein d’opportunités.
        </p>
    </div>
</section>

@if ($etablissement->bachelier_ouvert == 1)
    <div id="app">
        <Formstepsbachelier 
            :appurl="'{{ config('app.url') }}'"
            :etablissement="{{ json_encode($etablissement) }}"
            :filiere="{{ json_encode($filiere) }}"
            :filieres="{{ json_encode($filieres) }}"
        />
    </div>
@else
    <section class="ended-section">
        <div class="ended-card">
            <div class="logo-container">
                <div class="logo-bg"></div>
                <img src="{{ asset('images/logos/uh1.png') }}" alt="Université Hassan 1er" class="univ-logo">
            </div>
            <h2>📅 Les préinscriptions sont terminées</h2>
            <p>
                Les préinscriptions pour cette année universitaire à l’Université Hassan 1er sont désormais 
                <strong>clôturées</strong>.<br>
                Nous vous remercions pour votre confiance et votre intérêt.<br>
            </p>
            <a href="{{ url('/') }}" class="btn-retour">Retour à l’accueil</a>
        </div>
    </section>
@endif
@endsection
