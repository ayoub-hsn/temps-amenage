<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de Préinscription - Formation Initiale en Temps Aménagé</title>
    <link rel="icon" href="{{ asset('images/favicon-uh1.png') }}" type="image/x-icon">
    <style>
        @page {
            size: A4;
            margin: 10mm 10mm 35mm 10mm;
        }

        * {
            box-sizing: border-box;
        }

        html, body {
            height: auto;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
            font-size: 10.5px;
            background: #f8f9fa;
            color: #343a40;
        }

        .page {
            /* Removed flexbox from page */
            padding: 10px;
            padding-top: 20mm;
            position: relative;
        }

        header {
            display: block;
            align-items: center;
            margin-bottom: 0;
            position: absolute;
            top: 4mm;
            left: 10mm;
            right: 10mm;
            z-index: 20000;
        }

        .header-logo {
            height: 100px;
            max-width: 100%;
            display: inline-block;
        }

        .header-logo:first-child {
            float: left;
        }

        .header-logo:last-child {
            float: right;
        }

        .center-title {
            text-align: center;
            margin-top: 15mm;
            margin-bottom: 3px;
        }

        .center-title h1 {
            font-size: 14px;
            color: #0056b3;
            margin-bottom: 1px;
        }

        .center-title h2 {
            font-size: 10px;
            color: #6c757d;
            font-weight: normal;
            margin-top: 0;
        }

        .qr-logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0;
            margin-top: 0px;
            margin-bottom: 10px;
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
        }

        .qr-code {
            height: 80px;
        }

        .establishment-logo {
            height: 80px;
        }

        .section {
            background-color: white;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 15px; /* Increased padding for section */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); /* Subtle shadow for section */
        }

        .section-title {
            background-color: #0056b3;
            color: white;
            padding: 8px 15px; /* Increased padding for section title */
            font-weight: bold;
            border-radius: 5px 5px 0 0;
            margin-bottom: 12px; /* Increased margin */
            font-size: 12px; /* Slightly larger font */
            letter-spacing: 0.5px; /* Added letter spacing */
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px 6px; /* Increased padding for table cells */
            border-bottom: 1px solid #f1f1f1;
            vertical-align: top;
            font-size: 10px; /* Slightly larger font */
        }

        td.label {
            width: 40%;
            background-color: #e9ecef;
            font-weight: bold;
            color: #495057;
            padding-right: 15px; /* Added padding to label */
        }

        tr:last-child td {
            border-bottom: none;
        }

        .photo-container {
            text-align: center;
            padding-left: 5px;
        }

        .student-photo {
            width: 130px; /* Increased size */
            height: 130px; /* Increased size */
            object-fit: cover;
            border: 2px solid #007bff;
            border-radius: 10px; /* More rounded corners */
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1); /* Enhanced shadow */
            transition: transform 0.2s ease-in-out;
            margin-bottom: 10px; /* Increased space below photo */
        }

        .student-photo:hover {
            transform: scale(1.04);
        }

        .no-photo {
            width: 130px; /* Increased size */
            height: 130px; /* Increased size */
            border: 2px dashed #adb5bd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            border-radius: 10px;
            font-size: 11px; /* Increased font size */
            text-align: center;
            margin-bottom: 10px;
            position: relative;
            left: 20;
        }

        footer {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            width: 100%;
            font-size: 9px;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #ced4da;
            padding: 8px 0; /* Increased padding for footer */
            letter-spacing: 0.5px;
        }

        .warning {
            color: #dc3545;
            font-weight: bold;
            margin-bottom: 4px; /* Increased margin */
            font-size: 15px; /* Increased font size */
        }

        .rtl {
            direction: rtl;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="page">
        <header>
            <img src="{{ public_path('images/logos/ministere.png') }}" alt="Logo Ministère" class="header-logo">
            <img src="{{ public_path('images/logos/uh1-bag.png') }}" alt="Logo Université" class="header-logo">
        </header>

        <div class="center-title">
            <h1>FICHE DE PRÉINSCRIPTION</h1>
        </div>

        <div class="qr-logo-container">
             <div style="float: left;">
                <img src="data:image/png;base64,{{ $qrCode }}" alt="QR Code"  class="qr-code">
             </div>
             <div style="float: right;">
                <img src="{{ public_path($etablissement->logo) }}" alt="Logo Établissement" class="establishment-logo">
             </div>
             <div style="clear: both;"></div>
        </div>

        <div class="section">
            <div class="section-title">IDENTITÉ</div>
            <table>
                <tr>
                    <td class="label">CNE</td>
                    <td>{{ $etudiant->CNE }}</td>
                    <td rowspan="8" colspan="2" class="photo-container">
                        {{-- @if($etudiant->path_photo)
                            <img src="{{ public_path($etudiant->path_photo) }}" alt="Photo Étudiant" class="student-photo">
                        @else
                        @endif --}}
                        <div class="no-photo">Pas de photo</div>
                    </td>
                </tr>
                <tr><td class="label">CIN</td><td>{{ $etudiant->CIN }}</td></tr>
                <tr><td class="label">Nom - Prénom</td><td>{{ $etudiant->nom }} {{ $etudiant->prenom }}</td></tr>
                <tr><td class="label">Téléphone</td><td>{{ $etudiant->phone }}</td></tr>
                <tr><td class="label">Email</td><td>{{ $etudiant->email }}</td></tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">INFORMATIONS ACADÉMIQUES</div>
            <table>
                <tr><td class="label">Série du Bac</td><td>{{ $etudiant->serie }}</td></tr>
                <tr><td class="label">Licence</td><td>{{ $etudiant->typelicence }}</td></tr>
                <tr><td class="label">Spécialité du Licence</td><td>{{ $etudiant->specialitelp }}</td></tr>
                <tr><td class="label">Moyenne du Licence</td><td>{{ $etudiant->moyenne_licence }}</td></tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">CHOIX DE FILIÈRE</div>
            @php
                // Get nom_abrv safely or show a fallback
                function getFiliereAbrev($filieres, $id) {
                    return $filieres->firstWhere('id', $id)?->nom_abrv ?? 'Non défini';
                }
            @endphp

            @if ($etablissement->multiple_choix_filiere_master)
                <table>
                    <tr>
                        <td class="label">FILIÈRE (Premier Choix)</td>
                        <td>{{ getFiliereAbrev($filieres, $etudiant->filiere_choix_1) }}</td>
                    </tr>
                    <tr>
                        <td class="label">FILIÈRE (Deuxième Choix)</td>
                        <td>{{ getFiliereAbrev($filieres, $etudiant->filiere_choix_2) }}</td>
                    </tr>
                    <tr>
                        <td class="label">FILIÈRE (Troisième Choix)</td>
                        <td>{{ getFiliereAbrev($filieres, $etudiant->filiere_choix_3) }}</td>
                    </tr>
                </table>
            @else    
                <table>
                    <tr>
                        <td class="label">Filière</td>
                        <td>{{ getFiliereAbrev($filieres, $etudiant->filiere) }}</td>
                    </tr>
                </table>
            @endif

        </div>

        <footer>
            <div class="warning">Toute fausse information entraîne l'élimination du dossier de candidature.</div>
            Université Hassan 1er - Route de Casablanca km 3,5 BP 555 Settat - Maroc<br>
            Tél.: 05.23.72.12.75 / 05.23.72.12.76 | Fax: 05.23.72.12.75<br>
            E-mail: pre-inscription.temps-amenage@uhp.ac.ma
        </footer>
    </div>
</body>
</html>
