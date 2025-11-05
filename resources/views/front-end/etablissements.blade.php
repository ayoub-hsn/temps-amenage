<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Etablissements | Université Hassan 1er</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/style-contact.css') }}"> --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('css/style-welcome.css')}}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .container {
            display: flex;
            height: 100vh; /* Ensures full height */
            flex: 1;
        }


        .container {
    margin-left: 0 !important;
    padding-left: 0 !important;
}

        .sidebar {
            background: #004080;
            color: white;
            padding: 20px;
            width: 250px;
            flex-shrink: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            transition: width 0.5s ease;
        }


        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 10px;
            border-radius: 5px;
            transition: background 0.3s;
        }

        .sidebar ul li a:hover, .sidebar ul li.active a {
            background: #005bb5;
        }

        .content {
            flex: 1;
            padding: 20px;
            background: #f8f9fa;
            overflow-y: auto;
            transition: margin-left 0.5s ease;
        }

        .establishment-details {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.3s;
            text-align: center;
        }

        .establishment-details img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 15px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            border-radius: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .establishment-details h3 {
            color: #004080;
            margin-bottom: 10px;
            font-size: 1.5em;
            font-weight: 600;
        }

        .establishment-details p {
            color: #666;
            margin-bottom: 20px;
            font-size: 1em;
            font-weight: 400;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #0073e6;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: background 0.3s, transform 0.3s;
            font-size: 1em;
            font-weight: 500;
        }

        .btn:hover {
            background: #005bb5;
            transform: scale(1.05);
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
        <div class="header-content text-center">
            <h1>منصة التسجيل القبلي وإعادة التسجيل</h1>
            <p>Plateforme de préinscription et de réinscription</p>
        </div>
    </header>


    <div class="container">
        <aside class="sidebar">
            <ul class="establishment-links">
                <li data-id="fsjp" class="active"><a href="#">FSJP</a></li>
                <li data-id="encg"><a href="#">ENCG</a></li>
                <li data-id="fst"><a href="#">FST</a></li>
                <li data-id="ensa"><a href="#">ENSA</a></li>
                <li data-id="i3s"><a href="#">I3S</a></li>
                <li data-id="i2s"><a href="#">I2S</a></li>
                <li data-id="esef"><a href="#">ESEF</a></li>
                <li data-id="flash"><a href="#">FLASH</a></li>
                <li data-id="feg"><a href="#">FEG</a></li>
            </ul>
        </aside>
        <main class="content">
            <div id="establishment-details"></div>
        </main>
    </div>

    <footer>
        <p>&copy; 2025 Made By Ayoub Hassnioui. Tous droits réservés.</p>
        <div class="social-links">
            <a href="https://www.instagram.com/universitehassan/" target="_blank"><i class="fab fa-instagram"></i></a>
            <a href="https://www.facebook.com/uh1" target="_blank"><i class="fab fa-facebook"></i></a>
            <a href="https://twitter.com/uh1" target="_blank"><i class="fab fa-twitter"></i></a>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        const APP_URL = "{{ config('app.url') }}";
        const fsjp = @json($fsjp);
        const encg = @json($encg);
        const fst = @json($fst);
        const ensa = @json($ensa);
        const i3s = @json($i3s);
        const i2s = @json($i2s);
        const esef = @json($esef);
        const flash = @json($flash);
        const feg = @json($feg);
        console.log(fsjp.logo)


        document.addEventListener('DOMContentLoaded', function () {
        const menuToggle = document.querySelector(".menu-toggle");
        const navLinks = document.querySelector(".nav-links");

        menuToggle.addEventListener("click", () => {
            navLinks.classList.toggle("active");
            menuToggle.classList.toggle("active");
        });

        const currentPath = window.location.pathname.split("/").pop();
        const links = document.querySelectorAll(".nav-links a");
        links.forEach(link => {
            if (link.getAttribute("href") === currentPath) {
                link.classList.add("active");
            }
        });

        const establishments = {
            'feg': {
                'img': feg.logo,
                'title': feg.title || 'FEG',  // if your PHP data has title
                'description': feg.description,
                'masterLink': `${APP_URL}master/${feg.id}`,
                'licenceLink': `${APP_URL}licenceExcellence/${feg.id}`
            },
            'fsjp': {
                'img': fsjp.logo,
                'title': fsjp.title || 'FSJP',
                'description': fsjp.description,
                'masterLink': `${APP_URL}master/${fsjp.id}`,
                'licenceLink': `${APP_URL}licenceExcellence/${fsjp.id}`
            },
            'fst': {
                'img': fst.logo,
                'title': fst.title || 'FST',
                'description': fst.description,
                'masterLink': `${APP_URL}master/${fst.id}`,
                'licenceLink': `${APP_URL}licenceExcellence/${fst.id}`
            },
            'encg': {
                'img': encg.logo,
                'title': encg.title || 'ENCG',
                'description': encg.description,
                'masterLink': `${APP_URL}master/${encg.id}`,
                'licenceLink': `${APP_URL}licenceExcellence/${encg.id}`
            },
            'i2s': {
                'img': i2s.logo,
                'title': i2s.title || 'I2S',
                'description': i2s.description,
                'masterLink': `${APP_URL}master/${i2s.id}`,
                'licenceLink': `${APP_URL}licenceExcellence/${i2s.id}`
            },
            'i3s': {
                'img': i3s.logo,
                'title': i3s.title || 'I3S',
                'description': i3s.description,
                'masterLink': `${APP_URL}master/${i3s.id}`,
                'licenceLink': `${APP_URL}licenceExcellence/${i3s.id}`
            },
            'flash': {
                'img': flash.logo,
                'title': flash.title || 'FLASH',
                'description': flash.description,
                'masterLink': `${APP_URL}master/${flash.id}`,
                'licenceLink': `${APP_URL}licenceExcellence/${flash.id}`
            },
            'esef': {
                'img': esef.logo,
                'title': esef.title || 'ESEF',
                'description': esef.description,
                'masterLink': `${APP_URL}master/${esef.id}`,
                'licenceLink': `${APP_URL}licenceExcellence/${esef.id}`
            },
            'ensa': {
                'img': ensa.logo,
                'title': ensa.title || 'ENSA',
                'description': ensa.description,
                'masterLink': `${APP_URL}master/${ensa.id}`,
                'licenceLink': `${APP_URL}licenceExcellence/${ensa.id}`
            }
        };


        const establishmentLinks = document.querySelectorAll('.establishment-links li');
        const establishmentDetails = document.getElementById('establishment-details');

        establishmentLinks.forEach(link => {
            link.addEventListener('click', function () {
                establishmentLinks.forEach(el => el.classList.remove('active'));
                this.classList.add('active');
                const id = this.getAttribute('data-id');
                loadEstablishment(id);
            });
        });

        function loadEstablishment(id) {
            const establishment = establishments[id];
            establishmentDetails.innerHTML = `
                <div class="establishment-details active">
                    <img src="${establishment.img}" alt="${establishment.title} Logo">
                    <h3>${establishment.title}</h3>
                    <p>${establishment.description}</p>
                    <div class="buttons">
                        <a href="${establishment.masterLink}" class="btn btn-primary">Master</a>
                        <a href="${establishment.licenceLink}" class="btn btn-secondary">Licence</a>
                    </div>
                </div>
            `;
            setTimeout(() => {
                establishmentDetails.querySelector('.establishment-details').classList.add('active');
            }, 100);
        }

        // Load the first establishment by default and set the first link as active
        const firstLink = document.querySelector('.establishment-links li.active');
        if (firstLink) {
            loadEstablishment(firstLink.getAttribute('data-id'));
        }





    });





    </script>
</body>
</html>
