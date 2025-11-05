<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>CNE</th>
                <th>CIN</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Série de Bac</th>
                <th>Type de licence</th>
                <th>Mention de Licence</th>
                <th>Spécialité du Licence</th>
                <th>Etablissement</th>
                <th>Date Obtention du Diplôme</th>
                <th>Moyenne du Licence</th>
                <th>Secteur</th>
                <th>Poste</th>
                <th>Filière</th>
                <th>Vérification</th>
                <th>Motif</th>
            </tr>
        </thead>
        <tbody>
            @foreach($etudiants as $etudiant)
                <tr>
                    <td>{{ $etudiant->CNE }}</td>
                    <td>{{ $etudiant->CIN }}</td>
                    <td>{{ $etudiant->nom }}</td>
                    <td>{{ $etudiant->prenom }}</td>
                    <td>{{ $etudiant->email }}</td>
                    <td>{{ $etudiant->phone }}</td>
                    <td>{{ $etudiant->serie }}</td>
                    <td>{{ $etudiant->typelicence }}</td>
                    <td>{{ $etudiant->mentionlp }}</td>
                    <td>{{ $etudiant->specialitelp }}</td>
                    <td>{{ $etudiant->etblsmtLp }}</td>
                    <td>{{ $etudiant->date_obtention_LP }}</td>
                    <td>{{ $etudiant->moyenne_licence }}</td>
                    <td>{{ $etudiant->secteur }}</td>  
                    <td>{{ $etudiant->poste }}</td>
                    <td>{{ $etudiant->filiere_name }}</td>
                    <td>{{ $etudiant->verif ?? '' }}</td>
                    <td>{{ $etudiant->motif ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
