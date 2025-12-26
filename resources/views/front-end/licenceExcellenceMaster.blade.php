<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Université Hassan 1er - Formation Initiale en Temps Aménagé</title>
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
                {{-- <li><a href="{{ route('etablissements') }}" class="{{ Route::currentRouteNamed('etablissements') ? 'active' : '' }}">Etablissements</a></li> --}}
                <li><a href="{{ route('contact') }}" class="{{ Route::currentRouteNamed('contact') ? 'active' : '' }}">Contact</a></li>
                <li><a href="{{ route('login') }}">Connexion</a></li>
            </ul>
            <div class="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </nav>
        <div class="header-content">
            <h1>Bienvenue à l'Université Hassan 1<sup>er</sup></h1>
            <p>Excellence en éducation et recherche</p>
        </div>
    </header>

   <main>
       <section id="blog-slider" class="slider-section">
           <div class="slider-header">
               <h2>Nos Actualités</h2>
           </div>
           <div class="slider-container">
               <div class="slider">
                   @foreach ($actualites as $actualite)
                   <div class="slide">
                       <div class="slide-content-wrapper">
                           <div class="slide-image-wrapper">
                               <img src="{{ $actualite->image }}" alt="{{ $actualite->titre }}" class="slide-image">
                           </div>
                           <div class="slide-text">
                               <h3>{{ $actualite->titre }}</h3>
                               <p>
                                   {!! \Illuminate\Support\Str::limit(strip_tags($actualite->description), 150, '...') !!}
                               </p>
                               <a href="{{ route('actualite.show',['actualite' => $actualite->id]) }}" class="btn-read-more">Lire la suite</a>
                           </div>
                       </div>
                   </div>
                   @endforeach
               </div>
               <!-- Navigation Buttons -->
               <button class="slider-btn prev">❮</button>
               <button class="slider-btn next">❯</button>
           </div>
           <!-- Navigation Dots -->
           <div class="slider-dots"></div>
       </section>



       <section id="establishments">
           <h2>Nos Etablissements</h2>
           <div class="establishment-list">
               @foreach ($etablissements as $etablissement)
                   <div class="establishment">
                       <img src="{{asset($etablissement->logo)}}" alt="{{$etablissement->nom_abrev}} Logo">
                       <h3>{{$etablissement->nom_abrev}}</h3>
                       <p>{{$etablissement->nom}}</p>
                       <div class="btn-container">
                           <a href="{{ route('welcomeMaster',['etablissement' => $etablissement->id]) }}" class="btn master">Préinscription Master</a>
                           <a href="{{ route('welcomeLicenceExcelllence',['etablissement' => $etablissement->id]) }}" class="btn licence">Préinscription Licence</a>
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
        <p>&copy; 2025 Made By Ayoub Hassnioui. Tous droits réservés.</p>
        <div class="social-links">
            <a href="https://www.instagram.com/universitehassan/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/uh1" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/uh1" target="_blank"><i class="fab fa-twitter"></i></a>
        </div>
    </footer>

    <script src="{{asset('js/script.js')}}"></script>


    <script>
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        const prevButton = document.querySelector('.prev');
        const nextButton = document.querySelector('.next');
        const dotsContainer = document.querySelector('.slider-dots');

        let currentSlide = 0;
        const totalSlides = slides.length;
        const maxVisibleDots = 5; // Max number of dots to display at a time
        let autoSlideInterval;

        // Function to create limited dots dynamically
        function renderDots() {
            dotsContainer.innerHTML = ''; // Clear previous dots
            const startDot = Math.max(0, Math.min(currentSlide - Math.floor(maxVisibleDots / 2), totalSlides - maxVisibleDots));

            for (let i = startDot; i < startDot + Math.min(maxVisibleDots, totalSlides); i++) {
                const dot = document.createElement('span');
                dot.classList.add('dot');
                if (i === currentSlide) dot.classList.add('active');
                dot.dataset.index = i;
                dotsContainer.appendChild(dot);
            }

            // Add event listeners to the new dots
            const dots = document.querySelectorAll('.slider-dots .dot');
            dots.forEach(dot => {
                dot.addEventListener('click', (e) => {
                    updateSlide(parseInt(e.target.dataset.index));
                    resetAutoSlide();
                });
            });
        }

        // Update slide and re-render dots
        function updateSlide(index) {
            currentSlide = index;
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
            renderDots();
        }

        // Manual Navigation Buttons
        nextButton.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlide(currentSlide);
            resetAutoSlide();
        });

        prevButton.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlide(currentSlide);
            resetAutoSlide();
        });

        // Auto Slide Functionality
        function startAutoSlide() {
            autoSlideInterval = setInterval(() => {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSlide(currentSlide);
            }, 5000); // Slide changes every 5 seconds
        }

        function resetAutoSlide() {
            clearInterval(autoSlideInterval);
            startAutoSlide();
        }

        // Initialize dots and auto-slide
        renderDots();
        startAutoSlide();
    </script>


</body>
</html>
