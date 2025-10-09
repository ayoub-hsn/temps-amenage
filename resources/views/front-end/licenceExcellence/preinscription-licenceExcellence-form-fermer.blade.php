@extends('front-end.layouts.master')
@section('content')
<style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(to bottom, #ffffff, #e3f2fd);
        color: #333;
    }

    .deadline-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: calc(100vh - 150px);
        padding: 2rem;
        text-align: center;
        background: url('/path-to-university-background-image.jpg') no-repeat center center fixed;
        background-size: cover;
        position: relative;
    }


    .deadline-card {
        position: relative;
        z-index: 2;
        background: linear-gradient(135deg, #ffffff, #f5f7fa);
        border-radius: 20px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        padding: 3rem 2rem;
        max-width: 650px;
        width: 100%;
        animation: fadeIn 1s ease-out;
    }

    .deadline-card h1 {
        font-size: 3rem;
        font-weight: 700;
        color: #d84315;
        margin-bottom: 1rem;
        text-transform: uppercase;
    }

    .deadline-card p {
        font-size: 1.2rem;
        line-height: 1.8;
        margin-bottom: 2rem;
        color: #555;
    }

    .deadline-card .icon {
        font-size: 6rem;
        color: #ff7043;
        margin-bottom: 1.5rem;
        animation: bounce 1.5s infinite ease-in-out;
    }

    .deadline-card a {
        display: inline-block;
        text-decoration: none;
        background: linear-gradient(90deg, #1e88e5, #42a5f5);
        color: #ffffff;
        padding: 0.8rem 2.5rem;
        font-size: 1rem;
        font-weight: bold;
        border-radius: 30px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 10px 25px rgba(30, 136, 229, 0.5);
    }

    .deadline-card a:hover {
        background: linear-gradient(90deg, #1565c0, #1e88e5);
        transform: translateY(-3px);
    }

  

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    @keyframes bounce {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
</style>

<div class="deadline-container">
    <div class="deadline-card">
        <div class="icon">⏰</div>
        <h1>Délai Expiré</h1>
        <p>
            Nous sommes désolés de vous informer que la période de préinscription désormais terminée.
            Nous vous invitons à consulter régulièrement notre site pour les futures annonces et opportunités.
        </p>
        <a href="{{ url('/') }}">Retour à l'Accueil</a>
    </div>
</div>


@endsection
