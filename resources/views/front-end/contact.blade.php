<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Université Hassan 1er - Contact</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/style-contact.css') }}"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/style-welcome.css')}}">
    <link rel="icon" href="{{ asset('images/favicon-uh1.png') }}" type="image/x-icon">
    <style>
       #contact {
            padding: 50px 20px;
            background: #fff;
            text-align: center;
            flex-grow: 1;
        }

        .contact-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .contact-container h2 {
            margin-bottom: 30px;
            font-size: 2.5em;
            color: #004080;
            animation: fadeIn 1.5s ease-in-out;
            font-weight: 700;
        }

        .contact-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }

        .contact-item {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .contact-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .contact-item i {
            font-size: 2.5em;
            color: #0073e6;
            margin-bottom: 15px;
        }

        .contact-item h3 {
            color: #004080;
            margin-bottom: 10px;
            font-size: 1.5em;
            font-weight: 600;
        }

        .contact-item p {
            color: #666;
            margin-bottom: 20px;
            font-size: 1em;
            font-weight: 400;
            text-align: center;
        }


        #instructions h2 {
            animation: fadeIn 1.5s ease-in-out;
        }

        .alert-info a:hover {
            text-decoration: underline;
        }
    </style>
    <style>
        .magic-section {
            background: linear-gradient(145deg, #f4f9ff, #e6f0ff);
            padding: 60px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .magic-title {
            font-size: 2.5em;
            color: #004080;
            font-weight: 800;
            margin-bottom: 10px;
            animation: fadeInDown 1s ease-in-out;
        }

        .magic-subtitle {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 40px;
            animation: fadeInUp 1s ease-in-out;
        }

        .magic-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 30px;
            max-width: 1100px;
            margin: auto;
        }

        .magic-card {
            background: #ffffff;
            padding: 25px 20px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 64, 128, 0.08);
            transition: transform 0.4s, box-shadow 0.4s;
            position: relative;
            z-index: 1;
            animation: popIn 0.7s ease forwards;
            opacity: 0;
            transform: translateY(20px);
        }

        .magic-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 64, 128, 0.15);
        }

        .magic-icon {
            background: linear-gradient(135deg, #0073e6, #004080);
            width: 70px;
            height: 70px;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1em;
            margin: 0 auto 15px;
            box-shadow: 0 8px 18px rgba(0, 115, 230, 0.4);
        }

        .magic-card a {
            color: #004080;
            font-weight: 600;
            font-size: 1em;
            text-decoration: none;
            word-break: break-word;
        }

        .magic-card a:hover {
            color: #0073e6;
            text-decoration: underline;
        }

        .feg {
            grid-column: 1 / -1;
            max-width: 260px;
            margin: 0 auto;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes popIn {
            to {
                opacity: 1;
                transform: translateY(0);
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

    <section id="instructions" style="padding: 50px 20px; background-color: #e9e4e4; text-align: center;">
        <div class="container" style="max-width: 900px; margin: auto;">
            <h2 style="color: #004080; font-weight: 700; margin-bottom: 30px; font-size: 2.2em;">Informations importantes pour les candidats</h2>
            <div class="alert alert-info shadow-sm" style="font-size: 1.1em; background: #e6f0ff; color: #003366; border-left: 5px solid #0073e6; border-radius: 10px; text-align: center;">
                <p style="margin-bottom: 15px;">
                    Les étudiants souhaitant effectuer leur <strong>préinscription</strong> sont priés de bien lire les informations disponibles sur la plateforme.
                </p>
                <p style="margin-bottom: 15px;">
                    En cas de <strong>problème technique</strong> (erreurs, lenteurs, accès, etc.) ou pour toute <strong>question liée à votre établissement</strong> (offres de formation, admission, dates, etc.),<br>
                    veuillez <strong>nous contacter exclusivement</strong> à l’adresse suivante :<br>
                    <a href="mailto:pre-inscription.temps-amenage@uhp.ac.ma" style="color: #0073e6; font-weight: 600;">pre-inscription.temps-amenage@uhp.ac.ma</a>
                </p>
                <p style="margin-bottom: 0;">
                    <em>Note importante :</em> Ce contact est votre interlocuteur unique pour toute demande concernant la préinscription et les informations relatives aux établissements. Merci de votre compréhension.
                </p>
            </div>
        </div>
    </section>



    <section id="contact">
        <div class="contact-container">
            <h2>Contactez-nous</h2>
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <h3>Email</h3>
                    <p>pre-inscription.temps-amenage@uhp.ac.ma</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-phone-alt"></i>
                    <h3>Téléphone</h3>
                    <p>05.23.72.12.75 / 76</p>
                </div>
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <h3>Adresse</h3>
                    <p>Route de Casablanca Km 3,5 Universite Hassan 1er BP 539</p>
                </div>
            </div>
        </div>
    </section>


    <footer>
        <p>&copy; 2025 Made By Ayoub Hassnioui. Tous droits réservés.</p>
        <div class="social-links">
            <a href="https://www.instagram.com/universitehassan/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/uh1" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/uh1" target="_blank"><i class="fab fa-twitter"></i></a>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('js/script.js')}}"></script>
</body>
</html>
