<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Université UH1</title>
        <link rel="icon" href="{{ asset('images/favicon-uh1.png') }}" type="image/x-icon">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
       <style>

            html, body {
                height: 100%;
                margin: 0;
                display: flex;
                flex-direction: column;
            }

            body {
                font-family: "Montserrat", sans-serif;
            }

            main {
                flex: 1; /* Pushes the footer to the bottom */
            }

            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 2rem;
                background-color: #f9f9f9;
                border-bottom: 2px solid #00c4b5;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            }

            .navbar-logo img {
                max-height: 100px;
                margin: 0 20px;
            }

            .navbar-links {
                display: flex;
                gap: 2rem;
            }

            .nav-link {
                text-decoration: none;
                color: #333;
                font-weight: 600;
                padding: 10px 15px;
                transition: color 0.3s, background-color 0.3s;
                border-radius: 5px;
            }

            .nav-link:hover {
                color: #fff;
                background: linear-gradient(135deg, #0073e6, #00bfff);
            }

            .menu-toggle {
                display: none;
                flex-direction: column;
                cursor: pointer;
            }

            .menu-toggle span {
                height: 3px;
                width: 25px;
                background-color: #333;
                margin: 4px 0;
                border-radius: 2px;
            }

            footer {
                background: #004080;
                color: white;
                text-align: center;
                padding: 20px 0;
                padding: 20px 0;
                width: 100%;
            }

            footer p {
                margin: 0;
            }

            footer .social-links {
                margin-top: 10px;
            }

            footer .social-links a {
                color: white;
                text-decoration: none;
                font-size: 1.5em;
                margin: 0 10px;
                transition: color 0.3s;
            }

            footer .social-links a:hover {
                color: #0073e6;
            }

            /* Responsive Styles */
            @media (max-width: 768px) {
                .navbar-links,
                .establishment-logo {
                    display: none; /* Hidden by default */
                    flex-direction: column;
                    align-items: center;
                    gap: 1rem;
                    background-color: #f9f9f9;
                    padding: 1rem;
                    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
                    border-radius: 8px;
                    width: calc(100% - 60px);
                    position: absolute;
                    right: 30px;
                }
                .nav-links a:hover, .nav-links a.active {
                    padding: 9px 23px;
                }

                .navbar-links {
                    top: 100px; /* Position the navbar-links below the navbar */
                }

                .navbar-links.active {
                    display: flex;
                }

                .establishment-logo {
                    top: 39%;
                    margin-top: 10px; /* Add spacing between links and logo */
                    display: none;
                }

                .establishment-logo.active {
                    display: flex; /* Show the logo when active */
                }

                .menu-toggle {
                    display: flex;
                }
            }


        </style>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;800&display=swap" rel="stylesheet">
        {{-- <link rel="stylesheet" href="{{asset('form/style.css')}}"> --}}

    </head>
    <body>
        <nav class="navbar">
            <div class="navbar-logo university-logo">
                <img src="{{asset('form/images/uh1-vert-plus.PNG')}}" alt="Logo Université">
            </div>
            <div class="menu-toggle" id="menu-toggle">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <div class="navbar-links" id="navbar-links">
                <a href="{{ route('welcome') }}" class="nav-link" class="{{ Route::currentRouteNamed('welcome') ? 'active' : '' }}">Accueil</a>
                <a href="{{ route('nosformation') }}" class="nav-link" class="{{ Route::currentRouteNamed('nosformation') ? 'active' : '' }}">Formations</a>
                <a href="{{ route('contact') }}" class="nav-link" class="{{ Route::currentRouteNamed('contact') ? 'active' : '' }}">Contact</a>
                <a href="{{route('login')}}" class="nav-link">Connexion</a>
            </div>
            <div class="navbar-logo establishment-logo" id="establishment-logo">
                <img src="{{asset("images/logos/ministere.png")}}" alt="Logo Établissement">
            </div>
            {{-- @if ($etablissement)
                @else
                <div class="navbar-logo establishment-logo" id="establishment-logo">
                    <img src="{{asset('form/images/flash_logo.jpg')}}" alt="Logo Établissement">
                </div>
            @endif --}}

        </nav>

        <main>
            @yield('content')
        </main>

        <footer>
            <p>&copy; 2025 Made By Ayoub Hassnioui. Tous droits réservés.</p>
            <div class="social-links">
                <a href="https://www.instagram.com/universitehassan/" target="_blank"><i class="fab fa-instagram"></i></a>
                <a href="https://www.facebook.com/uh1" target="_blank"><i class="fab fa-facebook"></i></a>
                <a href="https://twitter.com/uh1" target="_blank"><i class="fab fa-twitter"></i></a>
            </div>
        </footer>

        <script src="{{ mix('js/app.js') }}"></script>
        <script>
            // Toggle menu visibility
            const menuToggle = document.getElementById('menu-toggle');
            const navbarLinks = document.getElementById('navbar-links');
            const establishmentLogo = document.getElementById('establishment-logo');

            menuToggle.addEventListener('click', () => {
                navbarLinks.classList.toggle('active');
                establishmentLogo.classList.toggle('active');
            });
        </script>
    </body>
    </html>

</head>

</html>
