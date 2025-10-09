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
                <th>Nom Arabe</th>
                <th>Prénom Arabe</th>
                <th>Date Naissance</th>
                <th>Sexe</th>
                <th>Pays</th>
                <th>Ville Naissance</th>
                <th>Ville (Arabe)</th>
                <th>Adresse</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Série</th>
                <th>Année Bac</th>
                <th>Dernier Diplôme Obtenu</th>
                <th>Type de Diplôme</th>
                <th>Spécialité du Diplôme</th>
                <th>Établissement du Diplôme</th>
                <th>Date Obtention du Diplôme</th>
                <th>Fonctionnaire</th>
                <th>Secteur</th>
                <th>Nombre Années</th>
                <th>Poste</th>
                <th>Lieu Travail</th>
                <th>Ville Travail</th>
                @if ($etablissement->multiple_choix_filiere_master == 0)
                <th>Filière</th>
                @else
                <th>Filière Choix 1</th>
                <th>Filière Choix 2</th>
                <th>Filière Choix 3</th>
                @endif

                @if ($etablissement->show_photo_input_master)
                <th>Lien Photo</th>
                @endif

                @if ($etablissement->show_cin_input_master)
                <th>Lien CIN</th>
                @endif

                @if ($etablissement->show_bac_input_master)
                <th>Lien Diplome Baccalauréat</th>
                @endif

                @if ($etablissement->show_licence_input_master)
                <th>Lien Diplome Licence</th>
                @endif

                @if ($etablissement->show_attestation_no_emploi_input_master)
                    <th>Attestation du non-emploi</th>
                @endif

                @if ($etablissement->show_cv_input_master)
                <th>Lien CV</th>
                @endif

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
                    <td>{{ $etudiant->nomar }}</td>
                    <td>{{ $etudiant->prenomar }}</td>
                    <td>{{ $etudiant->datenais }}</td>
                    <td>{{ $etudiant->sexe }}</td>
                    <td>{{ $etudiant->payschamp }}</td>
                    <td>{{ $etudiant->villenais }}</td>
                    <td>{{ $etudiant->villechamp }}</td>
                    <td>{{ $etudiant->adresse }}</td>
                    <td>{{ $etudiant->email }}</td>
                    <td>{{ $etudiant->phone }}</td>
                    <td>{{ $etudiant->serie }}</td>
                    <td>{{ $etudiant->Anneebac }}</td>

                    <td>{{ $etudiant->dernier_diplome_obtenu }}</td>
                    <td>{{ $etudiant->type_diplome_obtenu }}</td>
                    <td>{{ $etudiant->specialitediplome }}</td>
                    <td>{{ $etudiant->ville_etablissement_diplome }}</td>
                    <td>{{ $etudiant->date_optention_diplome }}</td>

                    <td>{{ $etudiant->fonctionnaire == 1 ? "OUI" : "NON" }}</td>
                    <td>{{ $etudiant->secteur }}</td>
                    <td>{{ $etudiant->nombreannee }}</td>
                    <td>{{ $etudiant->poste }}</td>
                    <td>{{ $etudiant->lieutravail }}</td>
                    <td>{{ $etudiant->villetravail }}</td>
                    @if ($etablissement->multiple_choix_filiere_master == 0)
                    <td>{{ $etudiant->filiere_name }}</td>
                    @else
                    <td>{{ $etudiant->filiere_choix_1_name }}</td>
                    <td>{{ $etudiant->filiere_choix_2_name }}</td>
                    <td>{{ $etudiant->filiere_choix_3_name }}</td>
                    @endif

                    @if ($etablissement->show_photo_input_master)
                    <td><a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_photo))]) }}" target="_blank">Afficher Photo</a></td>
                    @endif

                    @if ($etablissement->show_cin_input_master)
                    <td><a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_cin))]) }}" target="_blank">Afficher CIN</a></td>
                    @endif

                    @if ($etablissement->show_bac_input_master)
                    <td><a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_bac))]) }}" target="_blank">Afficher Diplome BAC</a></td>
                    @endif

                    @if ($etablissement->show_licence_input_master)
                    <td><a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_licence))]) }}" target="_blank">Afficher Diplome Licence</a></td>
                    @endif

                    @if ($etablissement->show_attestation_no_emploi_input_master)
                    <td><a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_attestation_non_emploi))]) }}" target="_blank">Afficher Attestation du non-emploi</a></td>
                    @endif

                    @if ($etablissement->show_cv_input_master)
                    <td><a href="{{ route('secure.file', ['hashedPath' => urlencode(Crypt::encryptString($etudiant->path_cv))]) }}" target="_blank">Afficher CV</a></td>
                    @endif
                    <td>{{ $etudiant->verif ?? '' }}</td>
                    <td>{{ $etudiant->motif ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
