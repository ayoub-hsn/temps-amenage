<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Statistiques des Établissements</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f2f2f2; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Statistiques des Candidats par Établissement</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Établissement</th>
                <th>Master</th>
                <th>Licence</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($etablissementStats as $index => $etab)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $etab->nom }}</td>
                    <td>{{ $etab->student_master_count }}</td>
                    <td>{{ $etab->student_passerelle_count }}</td>
                    <td>{{ $etab->student_master_count + $etab->student_passerelle_count }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
