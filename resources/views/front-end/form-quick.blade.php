@extends('front-end.layouts.master')

@section('content')
<style>
    /* === GLOBAL STYLES === */
    body {
        font-family: "Poppins", sans-serif;
        background: #f5f9ff;
        color: #004B87;
        overflow-x: hidden;
    }

    /* === HERO SECTION === */
    .hero-section {
        background: linear-gradient(120deg, #004B87, #007bff);
        color: white;
        text-align: center;
        padding: 100px 20px 80px;
        position: relative;
        overflow: hidden;
    }

    .hero-section::before {
        content: "";
        position: absolute;
        top: -100px;
        right: -100px;
        width: 350px;
        height: 350px;
        background: rgba(255, 255, 255, 0.08);
        filter: blur(80px);
        border-radius: 50%;
    }

    .hero-section h2 {
        font-size: 2.8em;
        font-weight: 800;
        margin-bottom: 20px;
    }

    .hero-section p {
        font-size: 1.2em;
        max-width: 900px;
        margin: 0 auto;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.95);
    }

    /* === ETABLISSEMENTS SECTION === */
    .etab-section {
        background: linear-gradient(180deg, #f4f8fc 0%, #e9f2fb 100%);
        padding: 120px 20px 100px;
        position: relative;
        overflow: hidden;
    }

    .etab-section::before {
        content: "";
        position: absolute;
        top: -100px;
        left: -100px;
        width: 350px;
        height: 350px;
        background: rgba(0, 75, 135, 0.1);
        filter: blur(90px);
        border-radius: 50%;
        z-index: 0;
    }

    .etab-section h3 {
        font-size: 2.4em;
        font-weight: 800;
        color: #004B87;
        margin-bottom: 20px;
        position: relative;
    }

    .etab-section h3::after {
        content: '';
        display: block;
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #004B87, #007bff);
        margin: 12px auto 0;
        border-radius: 2px;
    }

    .etab-subtitle {
        font-size: 1.1em;
        color: #004b87cc;
        margin-bottom: 60px;
        max-width: 850px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }

    .etab-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(330px, 1fr));
        gap: 40px;
        justify-items: center;
        position: relative;
        z-index: 1;
    }

    .etab-card {
        position: relative;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(16px);
        border-radius: 25px;
        box-shadow: 0 12px 35px rgba(0, 75, 135, 0.12);
        width: 100%;
        max-width: 370px;
        overflow: hidden;
        transition: all 0.5s ease;
        cursor: pointer;
    }

    .etab-bg {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: radial-gradient(circle at top left, #004B87 0%, #007bff 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 0;
    }

    .etab-content {
        position: relative;
        padding: 45px 25px;
        z-index: 1;
    }

    .etab-logo-container {
        width: 110px;
        height: 110px;
        margin: 0 auto 20px;
        background: #ffffff;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        border: 4px solid #004B87;
        box-shadow: 0 0 15px rgba(0, 75, 135, 0.15);
    }

    .etab-logo {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }

    .etab-name {
        font-size: 1.25rem;
        font-weight: 700;
        color: #004B87;
        margin-top: 10px;
    }

    .etab-line {
        width: 80px;
        height: 4px;
        background: linear-gradient(90deg, #004B87, #007bff);
        border-radius: 2px;
        margin: 15px auto;
        transition: width 0.3s ease;
    }

    .etab-description {
        color: #004b87cc;
        font-size: 0.95rem;
        line-height: 1.5;
        padding: 0 10px;
        transition: color 0.3s ease;
    }

    .etab-card:hover {
        transform: translateY(-12px) scale(1.03);
        box-shadow: 0 18px 45px rgba(0, 75, 135, 0.18);
    }

    .etab-card:hover .etab-bg {
        opacity: 1;
    }

    .etab-card:hover .etab-name,
    .etab-card:hover .etab-description {
        color: white;
    }

    .etab-card:hover .etab-line {
        background: white;
        width: 100px;
    }

    /* === PROGRAMME & FILIÈRES === */
    .program-options, .filiere-list {
        display: none;
        background: white;
        border-radius: 18px;
        padding: 40px 25px;
        margin-top: 50px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        animation: fadeIn 0.6s ease-in-out;
    }

    .program-btn {
        display: inline-block;
        margin: 10px 15px;
        padding: 14px 30px;
        border-radius: 35px;
        background: linear-gradient(135deg, #004B87, #007bff);
        color: white;
        border: none;
        font-weight: 600;
        transition: all 0.3s;
    }

    .program-btn:hover {
        background: linear-gradient(135deg, #0066b3, #0090ff);
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0, 75, 135, 0.25);
    }

    .btn-retour {
        display: inline-block;
        margin-top: 30px;
        background: linear-gradient(135deg, #004B87, #007bff);
        color: white;
        padding: 12px 25px;
        border-radius: 30px;
        font-weight: 600;
        transition: 0.3s;
        border: none;
    }

    .btn-retour:hover {
        background: linear-gradient(135deg, #0066b3, #0090ff);
        transform: translateY(-2px);
    }

    .filiere-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        justify-items: center;
    }

    .filiere-item {
        background: white;
        border-radius: 15px;
        padding: 20px 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        transition: 0.3s;
        font-weight: 600;
        color: #004B87;
        text-decoration: none;
        width: 100%;
        max-width: 340px;
    }

    .filiere-item:hover {
        background: linear-gradient(135deg, #004B87, #007bff);
        color: white;
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0, 75, 135, 0.2);
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* === RESPONSIVE === */
    @media (max-width: 768px) {
        .hero-section h2 {
            font-size: 2.1em;
        }
        .etab-section {
            padding: 80px 15px;
        }
        .etab-card {
            max-width: 100%;
        }
    }
</style>

<!-- === HERO === -->
<section class="hero-section">
    <div class="container">
        <h2>🎓 Bienvenue à l’Université Hassan 1er</h2>
        <p>
            Rejoignez une université moderne qui allie excellence académique, innovation et ouverture sur le monde.<br>
            Nos formations visent à construire les leaders et innovateurs du Maroc de demain.
        </p>
    </div>
</section>

<!-- === ETABLISSEMENTS === -->
<section class="etab-section">
    <div class="container text-center">
        <h3>Nos Établissements</h3>
        <p class="etab-subtitle">
            Découvrez les établissements de l’Université Hassan 1er qui forment l’élite de demain.
            Choisissez votre parcours et préparez votre avenir dans un environnement d’excellence.
        </p>

        <div class="etab-grid">
            @foreach($etablissements as $etab)
                <div class="etab-card" data-etab="{{ $etab->id }}">
                    <div class="etab-bg"></div>
                    <div class="etab-content">
                        <div class="etab-logo-container">
                            <img src="{{ asset($etab->logo) }}" alt="{{ $etab->nom_abrev }}" class="etab-logo">
                        </div>
                        <div class="etab-name">{{ $etab->nom }}</div>
                        <div class="etab-line"></div>
                        <p class="etab-description">
                            Explorez les programmes innovants et les formations de qualité proposés par cet établissement.
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- === PROGRAMME OPTIONS & FILIÈRES === -->
        @foreach($etablissements as $etab)
            <div class="program-options" id="program-options-{{ $etab->id }}">
                <button class="program-btn" data-type="master" data-etab="{{ $etab->id }}">🎓 Master</button>
                <button class="program-btn" data-type="licence" data-etab="{{ $etab->id }}">📘 Licence (Accès S5)</button>
                <button class="program-btn" data-type="bachelier" data-etab="{{ $etab->id }}">🎒 Licence (Accès S1)</button>
                <br>
                <button class="btn-retour retour-program" data-etab="{{ $etab->id }}">← Retour aux établissements</button>
            </div>

            <div class="filiere-list" id="filiere-master-{{ $etab->id }}">
                <div class="filiere-grid">
                    @foreach($etab->filiereMaster as $f)
                        <a href="{{ route('master.nosformationChoisen', $f->id) }}" class="filiere-item">{{ $f->nom_complet }}</a>
                    @endforeach
                </div>
                <button class="btn-retour retour-filiere" data-etab="{{ $etab->id }}">← Retour aux programmes</button>
            </div>

            <div class="filiere-list" id="filiere-licence-{{ $etab->id }}">
                <div class="filiere-grid">
                    @foreach($etab->filiereLicence as $f)
                        <a href="{{ route('licence.nosformationChoisen', $f->id) }}" class="filiere-item">{{ $f->nom_complet }}</a>
                    @endforeach
                </div>
                <button class="btn-retour retour-filiere" data-etab="{{ $etab->id }}">← Retour aux programmes</button>
            </div>

            <div class="filiere-list" id="filiere-bachelier-{{ $etab->id }}">
                <div class="filiere-grid">
                    @foreach($etab->filiereBachelier as $f)
                        <a href="{{ route('bachelier.nosformationChoisen', $f->id) }}" class="filiere-item">{{ $f->nom_complet }}</a>
                    @endforeach
                </div>
                <button class="btn-retour retour-filiere" data-etab="{{ $etab->id }}">← Retour aux programmes</button>
            </div>
        @endforeach
    </div>
</section>

<!-- === SCRIPTS === -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function() {
    // === Click on Etablissement ===
    $('.etab-card').click(function() {
        const id = $(this).data('etab');
        $('.etab-card').not(this).fadeOut(400);
        $(this).addClass('selected').css('transform', 'scale(1.05)');

        $('#program-options-' + id).slideDown(500, function() {
            $('html, body').animate({
                scrollTop: $(this).offset().top - 80
            }, 800);
        });
    });

    // === Retour to Etablissements ===
    $('.retour-program').click(function() {
        const id = $(this).data('etab');
        $('#program-options-' + id).fadeOut(400, function() {
            $('.etab-card').fadeIn(400).css('transform', '');
            $('html, body').animate({
                scrollTop: $('.etab-section').offset().top - 80
            }, 800);
        });
    });

    // === Click on Program Button ===
    $('.program-btn').click(function() {
        const id = $(this).data('etab');
        const type = $(this).data('type');
        $('#program-options-' + id).fadeOut(300, function() {
            const filiereDiv = $('#filiere-' + type + '-' + id);
            filiereDiv.fadeIn(400, function() {
                $('html, body').animate({
                    scrollTop: filiereDiv.offset().top - 80
                }, 800);
            });
        });
    });

    // === Retour from Filiere to Program ===
    $('.retour-filiere').click(function() {
        const id = $(this).data('etab');
        const filieres = $('#filiere-master-' + id + ', #filiere-licence-' + id + ', #filiere-bachelier-' + id);
        filieres.fadeOut(300, function() {
            const programDiv = $('#program-options-' + id);
            programDiv.fadeIn(400, function() {
                $('html, body').animate({
                    scrollTop: programDiv.offset().top - 80
                }, 800);
            });
        });
    });
});
</script>
@endsection
