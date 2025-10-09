<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Filières par Établissement</title>
    <style>
        @font-face {
            font-family: 'Tajawal';
            /* dompdf needs absolute file path */
            src: url("{{ public_path('fonts/Tajawal-Regular.ttf') }}") format("truetype");
            font-weight: normal;
            font-style: normal;
        }

        body {
            font-family: 'amiri', serif;
        }

        .arabic-text {
            font-family: 'amiri', serif;
            direction: rtl;
            unicode-bidi: embed;
            text-align: right;
        }

        h2 { text-align: center; margin-bottom: 30px; }
        .etab-header {
            background-color: #e0e0e0;
            padding: 10px;
            font-weight: bold;
            margin-top: 30px;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        hr {
            border: none;
            border-top: 1px solid #aaa;
            margin: 40px 0 20px;
        }

    </style>
</head>
<body>
    <h2>Statistiques des Filières par Établissement</h2>

    @foreach ($allData as $index => $data)
        @if($index > 0)
            <hr>
        @endif

        <div class="etab-header">{{ $data['etablissement'] }}</div>

        <strong>Filières Master</strong>
        <table>
            <thead>
                <tr>
                    <th>Filière</th>
                    <th>Responsable</th>
                    <th>Nombre d'étudiants</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['master'] as $filiere)
                    @php
                        $isArabic = preg_match('/\p{Arabic}/u', $filiere->nom_complet);
                    @endphp
                    <tr @if($isArabic) dir="rtl" class="arabic-text" @endif>
                        <td>{{ $filiere->nom_complet }} ({{ $filiere->nom_abrv ?? '' }})</td>
                        <td>{{ $filiere->responsable ?? 'N/A' }}</td>
                        <td>{{ $filiere->students_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">Aucune filière Master</td></tr>
                @endforelse

            </tbody>
        </table>

        <strong>Filières Licence</strong>
        <table>
            <thead>
                <tr>
                    <th>Filière</th>
                    <th>Responsable</th>
                    <th>Nombre d'étudiants</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['passerelle'] as $filiere)
                    @php
                        $isArabic = preg_match('/\p{Arabic}/u', $filiere->nom_complet);
                    @endphp
                    <tr @if($isArabic) dir="rtl" class="arabic-text" @endif>
                        <td>{{ $filiere->nom_complet }} ({{ $filiere->nom_abrv ?? '' }})</td>
                        <td>{{ $filiere->responsable ?? 'N/A' }}</td>
                        <td>{{ $filiere->students_count }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3">Aucune filière Licence</td></tr>
                @endforelse


            </tbody>
        </table>
    @endforeach
</body>
</html>
