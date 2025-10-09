<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Université Hassan 1er - Nos Formations</title>
    <link rel="stylesheet" href="{{asset('css/styles-welcomeLEM.css')}}">
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


        <!-- Hero Banner -->
        <div class="hero-banner">
            <h1>Boostez votre carrière avec nos formations initiale à Temps Aménagé</h1>
            <p>Développez vos compétences, maîtrisez les technologies et devenez un acteur clé dans votre domaine.</p>
        </div>

       <section id="establishments">
           <h2>Nos Etablissements</h2>
           <div class="establishment-list">
               @foreach ($etablissements as $etablissement)
                   <div class="establishment">
                       <img src="{{asset($etablissement->logo)}}" alt="{{$etablissement->nom_abrev}} Logo">
                       <h3>{{$etablissement->nom_abrev}}</h3>
                       <p>{{$etablissement->nom}}</p>
                       <div class="btn-container">
                           <a href="{{ route('formationMaster',['etablissement' => $etablissement->id]) }}" class="btn master">Masters Universitaires</a>
                           <a href="{{ route('formationLicence',['etablissement' => $etablissement->id]) }}" class="btn licence">Licences Universitaires</a>
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
                       allowfullscreen=""
                       loading="lazy"
                       referrerpolicy="no-referrer-when-downgrade">
                   </iframe>
               </div>
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

    <script src="{{asset('js/script.js')}}"></script>

</body>
</html>
