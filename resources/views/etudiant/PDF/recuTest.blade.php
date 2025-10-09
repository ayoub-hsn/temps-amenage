<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Fiche de Préinscription</title>
    <style>
        @page {
            size: A4;
            margin: 15mm 10mm 20mm 10mm;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10.5px; /* Further slight reduction in base font */
            background: #f8f9fa;
            color: #343a40;
            display: flex;
            flex-direction: column;
            min-height: 277mm;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px; /* Further reduced header margin */
        }

        .header-logo {
            width: 130px; /* Slightly smaller logos again */
            height: auto;
        }

        .center-title {
            text-align: center;
            margin-bottom: 8px; /* Further reduced title margin */
        }

        .center-title h1 {
            font-size: 13px; /* Smaller main title */
            color: #0056b3;
            margin-bottom: 1px;
        }

        .center-title h2 {
            font-size: 9px; /* Smaller subtitle */
            color: #6c757d;
            font-weight: normal;
            margin-top: 0;
        }

        .qr-logo-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 0; /* Further reduced padding */
            margin-bottom: 8px; /* Further reduced margin */
            border-top: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
        }

        .qr-code,
        .establishment-logo {
            width: 160px; /* Even smaller QR and logo */
            height: 90px;
            text-align: center;
        }

        .section {
            background-color: white;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-bottom: 10px; /* Keep some separation */
            padding: 10px; /* Keep some internal padding */
        }

        .section-title {
            background-color: #0056b3;
            color: white;
            padding: 4px 8px; /* Further reduced title padding */
            font-weight: bold;
            border-radius: 5px 5px 0 0;
            margin-bottom: 6px;
            font-size: 11px; /* Smaller section title */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 4px; /* Add a little space above the table */
        }

        td {
            padding: 3px 6px; /* Even smaller cell padding */
            border-bottom: 1px solid #f8f9fa;
            vertical-align: top;
            font-size: 9.5px; /* Even smaller table font */
        }

        td.label {
            width: 40%; /* Slightly wider label column */
            background-color: #e9ecef;
            font-weight: bold;
            color: #495057;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .photo-container {
            text-align: center;
            padding-left: 5px; /* Add a little left padding for the photo */
        }

        .student-photo {
            width: 70px; /* Even smaller photo */
            height: 90px;
            object-fit: cover;
            border: 1px solid #adb5bd;
            border-radius: 3px;
        }

        .no-photo {
            width: 70px;
            height: 90px;
            border: 1px dashed #adb5bd;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            border-radius: 3px;
            font-size: 8.5px;
            text-align: center;
        }

        footer {
            position: absolute;
            bottom: 10mm;
            left: 10mm;
            right: 10mm;
            font-size: 9px;
            text-align: center;
            color: #6c757d;
            border-top: 1px solid #ced4da;
            padding-top: 2px; /* Further reduced footer padding */
        }

        .warning {
            color: #dc3545;
            font-weight: bold;
            margin-bottom: 2px;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="page">
        <header>
            <img src="{{ asset('images/logos/ministere.jpg') }}" alt="Logo Ministère" class="header-logo" style="float: left;">
            <img src="{{ asset('images/logos/uh1.png') }}" alt="Logo Université" class="header-logo" style="float: right;">
        </header>

        <div class="center-title">
            <h1>FICHE DE PRÉINSCRIPTION</h1>
            <h2>استمارة التسجيل القبلي</h2>
        </div>

        <div class="qr-logo-container">
            <div class="qr-code" style="float: left;">
                <img src="{{ $qrCode }}" alt="QR Code" style="width: 55px; height: 75px;">
            </div>
            <div class="establishment-logo" style="float: right;">
                <img src="{{ asset($etablissement->logo) }}" alt="Logo Établissement" style="height: 75px;">
            </div>
        </div>

        <div class="section">
            <div class="section-title">IDENTITÉ / الهوية</div>
            <table>
                <tr>
                    <td class="label">CNE</td>
                    <td>{{ $etudiant->CNE }}</td>
                    <td rowspan="8" colspan="2" class="photo-container">
                        @if($etudiant->path_photo)
                            <img src="{{ asset($etudiant->path_photo) }}" alt="Photo Étudiant" class="student-photo">
                        @else
                            <div class="no-photo">Pas de photo</div>
                        @endif
                    </td>
                </tr>
                <tr><td class="label">CIN</td><td>{{ $etudiant->CIN }}</td></tr>
                <tr><td class="label">Nom</td><td>{{ $etudiant->nom }}</td></tr>
                <tr><td class="label">Prénom</td><td>{{ $etudiant->prenom }}</td></tr>
                <tr><td class="label">Date de Naissance</td><td>{{ $etudiant->datenais }}</td></tr>
                <tr><td class="label">Ville de Naissance</td><td>{{ $etudiant->villenais }}</td></tr>
                <tr><td class="label">Téléphone</td><td>{{ $etudiant->phone }}</td></tr>
                <tr><td class="label">Email</td><td>{{ $etudiant->email }}</td></tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">INFORMATIONS ACADÉMIQUES / المعطيات الأكاديمية</div>
            <table>
                <tr><td class="label">Série du Bac</td><td>{{ $etudiant->serie }}</td></tr>
                <tr><td class="label">Année d'Obtention</td><td>{{ $etudiant->Anneebac }}</td></tr>
                <tr><td class="label">Mention</td><td>{{ $etudiant->mention_bac }}</td></tr>
                <tr><td class="label">Moyenne Bac</td><td>{{ $etudiant->notebac }}</td></tr>
                <tr><td class="label">Spécialité</td><td>{{ $etudiant->specialitelp }}</td></tr>
                <tr><td class="label">Établissement</td><td>{{ $etablissement->nom_abrev }}</td></tr>
            </table>
        </div>

        <div class="section">
            <div class="section-title">CHOIX DE FILIÈRE / اختيار المسلك</div>
            <table>
                <tr><td class="label">Filière</td><td>{{ $etudiant->filiere }}</td></tr>
            </table>
        </div>
    </div>

    <footer>
        <div class="warning">Toute fausse information entraîne l'élimination du dossier de candidature.</div>
        Université Hassan 1er - Route de Casablanca km 3,5 BP 555 Settat - Maroc<br>
        Tél.: 05 23 40 01 87 / 05 23 72 64 62 | Fax: 05 23 40 01 87<br>
        E-mail: feg.settat@uhp.ac.ma
    </footer>
</body>
</html>