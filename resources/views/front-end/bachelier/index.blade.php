<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Université Hassan 1er</title>
    <link rel="stylesheet" href="{{asset('css/styles-welcomeLEM.css')}}">
    <link rel="stylesheet" href="{{asset('css/styles-indexBacheliers.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



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

    <main class="main-section">
        <section class="welcome-section">
            <h1>Préinscriptions Universitaires 2025-2026</h1>
            <p class="intro-text">
                L'Université Hassan 1er a le plaisir de lancer l'ouverture des préinscriptions en ligne pour ses établissements pour l'année universitaire <strong>2025-2026</strong>.
            </p>

            <!-- Info Card Section -->
            <div class="info-card">
                <h2>Informations Générales</h2>
                <p>
                    Pour les préinscriptions aux établissements à accès ouvert, il est nécessaire de <strong>télécharger le formulaire de préinscription</strong> et de l’imprimer pour le présenter dans le service de scolarité au moment de l’inscription définitive.
                </p>
            </div>

            <!-- Access Types Section -->
            <div class="access-types">
                <div class="access-box">
                    <i class="fas fa-university"></i>
                    <h3>Etablissements à accès ouvert</h3>
                    <div class="button-group">
                        <a href="{{ route('bacheliers.acceeOuvert') }}" class="custom-btn">Préinscription</a>
                        <a href="reins.html" class="custom-btn">Réinscription</a>
                    </div>
                </div>

                <div class="access-box">
                    <i class="fas fa-lock"></i>
                    <h3>Etablissements à accès régulé</h3>
                    <div class="button-group">
                        <a href="ER.html" class="custom-btn">Préinscription</a>
                    </div>
                </div>
            </div>

            <!-- Process Section -->
            <div class="process-section">
                <h2>Processus d'inscription</h2>
                <p>
                    Dépôt du dossier d'inscription définitif dans l'établissement choisi selon les dates qui seront déterminées ultérieurement.
                </p>
                <h3>Pièces obligatoires :</h3>
                <ul class="documents-list">
                    <li><i class="fas fa-file-alt"></i> Baccalauréat original + une copie</li>
                    <li><i class="fas fa-file-alt"></i> Relevé de notes du Baccalauréat</li>
                    <li><i class="fas fa-id-card"></i> Photocopie de la CIN</li>
                    <li><i class="fas fa-baby"></i> Acte de naissance pour les non titulaires de la CIN biométrique</li>
                    <li><i class="fas fa-camera"></i> 2 Photos d’identité récentes</li>
                    <li><i class="fas fa-receipt"></i> Reçu de préinscription avec code à imprimer</li>
                </ul>
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
