<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Université Hassan 1er</title>
    <link rel="stylesheet" href="{{asset('css/styles-welcomeLEM.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom right, #f0f4ff, #e6efff);
            color: #0a2540;
        }

        .modern-filieres-section {
            padding: 50px 20px;
        }

        .filieres-wrapper {
            max-width: 1300px;
            margin: auto;
            text-align: center;
        }

        .page-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 40px;
            color: #004aad;
        }

        .filieres-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            justify-content: center;
        }

        .filiere-link {
            cursor: pointer;
            text-decoration: none;
            position: relative;
            display: block;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 20px;
        }

        .filiere-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            transition: 0.3s ease;
            border: 3px solid transparent;
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .filiere-link:hover .filiere-card {
            transform: translateY(-6px);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.08);
        }

        .card-top {
            background: linear-gradient(to right, #004aad, #0074e4);
            padding: 25px;
            text-align: center;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .etab-logo {
            width: 70px;
            height: 70px;
            object-fit: contain;
            background: #fff;
            border-radius: 50%;
            padding: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .filiere-abbr {
            font-size: 1.7rem;
            font-weight: bold;
            color: #fff;
        }

        .card-body {
            padding: 25px 20px;
            flex-grow: 1;
        }

        .card-body h3 {
            font-size: 1.15rem;
            margin-bottom: 18px;
        }

        .btn-doc {
            display: inline-block;
            padding: 10px 16px;
            background-color: #004aad;
            color: #fff;
            font-size: 0.9rem;
            border-radius: 8px;
            text-decoration: none;
            transition: background 0.3s ease;
        }

        .btn-doc:hover {
            background-color: #003b87;
        }

        .btn-doc i {
            margin-right: 6px;
        }

        .no-doc {
            font-size: 0.85rem;
            color: #777;
            font-style: italic;
        }

        .choice-badge {
            position: absolute;
            top: 14px;
            right: 14px;
            background-color: #004aad;
            color: #fff;
            font-size: 0.8rem;
            padding: 6px 12px;
            border-radius: 12px;
            display: none;
            z-index: 2;
        }

        .filiere-link.selected .choice-badge {
            display: block;
        }

        .filiere-link.selected .filiere-card {
            border: 3px solid #004aad;
            box-shadow: 0 0 20px rgba(0, 74, 173, 0.2);
        }

        .submit-btn {
            margin-top: 40px;
            padding: 14px 28px;
            background-color: #0074e4;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #005dc0;
        }

        @media (max-width: 500px) {
            .page-title {
                font-size: 2rem;
            }

            .card-body h3 {
                font-size: 1rem;
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


    <main class="modern-filieres-section">
        <div class="filieres-wrapper">
            <h2 class="page-title">{{ $etablissement->nom }}</h2>

            <form method="POST" action="{{ route('bacheliers.welcomeBacAcceOuvert.form.apply',['etablissement' => $etablissement->id]) }}">
                @csrf
                <input type="hidden" name="filiere_id" id="selectedFiliereId" />

                <div class="filieres-cards">
                    <input type="hidden" name="CIN" value="{{ $CIN }}">
                    <input type="hidden" name="datenais" value="{{ $datenais }}">
                    <input type="hidden" name="province" value="{{ $province }}">
                    @forelse($filieres as $filiere)
                        <label class="filiere-link" data-id="{{ $filiere->id }}">
                            <input type="radio" name="filiere" value="{{ $filiere->id }}" class="filiere-radio" hidden>

                            <div class="filiere-card">
                                <div class="card-top">
                                    <img src="{{ asset($etablissement->logo) }}" class="etab-logo" alt="Logo {{ $etablissement->nom }}">
                                    <div class="filiere-abbr">{{ $filiere->nom_abrv }}</div>
                                </div>
                                <div class="card-body">
                                    <h3>{{ $filiere->nom_complet }}</h3>
                                    @if($filiere->document)
                                        <a href="{{ asset($filiere->document) }}" target="_blank" class="btn-doc" onclick="event.stopPropagation();">
                                            <i class="fas fa-file-download"></i> Télécharger le document
                                        </a>
                                    @else
                                        <span class="no-doc">Aucun document</span>
                                    @endif
                                </div>
                                <div class="choice-badge">🎓 Mon choix</div>
                            </div>
                        </label>
                    @empty
                        <p style="text-align: center; font-size: 1.1rem; color: #555; margin-top: 20px;">
                            Aucune filière n'est disponible pour cet établissement pour le moment.
                        </p>
                    @endforelse

                </div>

                @if($filieres->isEmpty())

                @else
                    <button type="submit" class="submit-btn">Confirmer mon choix</button>
                @endif
            </form>
        </div>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(function () {
            $('.filiere-link').click(function () {
                // Remove the "selected" class from all cards
                $('.filiere-link').removeClass('selected');
                $('.filiere-radio').prop('checked', false);

                // Add "selected" class to clicked card
                $(this).addClass('selected');
                $(this).find('.filiere-radio').prop('checked', true);

                // Update the hidden input with the selected filière id
                $('#selectedFiliereId').val($(this).data('id'));
            });
        });
    </script>



</body>
</html>
