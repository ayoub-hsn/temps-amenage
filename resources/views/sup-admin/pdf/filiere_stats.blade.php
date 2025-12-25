<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des Filières par Établissement</title>
    <style>
        /* ✅ mPDF built-in fonts support Arabic + Latin */
        body {
            font-family: 'dejavusans', 'Amiri', sans-serif;
            direction: ltr;
            color: #000;
            font-size: 12px;
            line-height: 1.5;
            margin: 20px;
        }

        h1 {
            text-align: center;
            font-size: 18px;
            color: #0d6efd;
            margin-bottom: 5px;
        }

        h2 {
            text-align: center;
            font-size: 16px;
            margin-bottom: 25px;
            color: #1a1a1a;
        }

        .etab-header {
            background-color: #e9ecef;
            padding: 10px;
            font-weight: bold;
            font-size: 14px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 25px;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px 8px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        .arabic-text {
            direction: rtl;
            text-align: right;
            font-family: 'dejavusans', 'Amiri', sans-serif;
        }

        .section-title {
            font-weight: bold;
            font-size: 13px;
            color: #0d6efd;
            margin-bottom: 5px;
        }

        .empty-text {
            text-align: center;
            font-style: italic;
            color: #666;
        }

        /* ✅ Each établissement starts on a new page */
        .page-break {
            page-break-after: always;
        }

        /* ✅ Add light separator line */
        hr {
            border: none;
            border-top: 1px solid #ccc;
            margin: 20px 0;
        }
    </style>
</head>
<body>

@foreach ($allData as $index => $data)
    <div class="etab-page">

        <h1>Statistiques de la plateforme de formation initiale en temps aménagé</h1>
        <h2>Université Hassan 1er – {{ $data['etablissement'] }}</h2>

        {{-- 🌐 Filières Master --}}
        <div class="section-title">Filières Master</div>
        <table>
            <thead>
                <tr>
                    <th>Filière</th>
                    <th>Nombre d'étudiants</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['master'] as $filiere)
                    @php
                        $isArabic = preg_match('/\p{Arabic}/u', $filiere->nom_complet);
                    @endphp
                    <tr @if($isArabic) class="arabic-text" @endif>
                        <td>{{ $filiere->nom_complet }} @if($filiere->nom_abrv) ({{ $filiere->nom_abrv }}) @endif</td>
                        <td>{{ $filiere->students_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="empty-text">Aucune filière</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- 🌐 Filières Licence (Accès S5) --}}
        <div class="section-title">Filières Licence (Accès S5)</div>
        <table>
            <thead>
                <tr>
                    <th>Filière</th>
                    <th>Nombre d'étudiants</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['passerelle'] as $filiere)
                    @php
                        $isArabic = preg_match('/\p{Arabic}/u', $filiere->nom_complet);
                    @endphp
                    <tr @if($isArabic) class="arabic-text" @endif>
                        <td>{{ $filiere->nom_complet }} @if($filiere->nom_abrv) ({{ $filiere->nom_abrv }}) @endif</td>
                        <td>{{ $filiere->students_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="empty-text">Aucune filière</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- 🌐 Filières Licence (Accès S1) --}}
        <div class="section-title">Filières Licence (Accès S1)</div>
        <table>
            <thead>
                <tr>
                    <th>Filière</th>
                    <th>Nombre d'étudiants</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data['bachelier'] as $filiere)
                    @php
                        $isArabic = preg_match('/\p{Arabic}/u', $filiere->nom_complet);
                    @endphp
                    <tr @if($isArabic) class="arabic-text" @endif>
                        <td>{{ $filiere->nom_complet }} @if($filiere->nom_abrv) ({{ $filiere->nom_abrv }}) @endif</td>
                        <td>{{ $filiere->students_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" class="empty-text">Aucune filière</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

    {{-- ✅ Force new page except for the last --}}
    @if (!$loop->last)
        <div class="page-break"></div>
    @endif
@endforeach

</body>
</html>
