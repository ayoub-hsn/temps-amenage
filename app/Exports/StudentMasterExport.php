<?php

namespace App\Exports;

use App\Models\StudentMaster;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView; // Make sure to include this
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class StudentMasterExport implements FromView, WithColumnWidths
{
    protected $etablissement;
    protected $etudiants;

    public function __construct($etablissement, $etudiants)
    {
        $this->etablissement = $etablissement;
        $this->etudiants = $etudiants;
    }

    public function view(): View
    {
        return view('exports.students_master', [
            'etablissement' => $this->etablissement,
            'etudiants' => $this->etudiants,
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20, // CNE
            'B' => 25, // CIN
            'C' => 30, // Nom
            'D' => 30, // Prénom
            'E' => 25, // Nom Arabe
            'F' => 25, // Prénom Arabe
            'G' => 25, // Date Naissance
            'H' => 15, // Sexe
            'I' => 20, // Pays
            'J' => 25, // Ville Naissance
            'K' => 25, // Ville (Arabe)
            'L' => 30, // Adresse
            'M' => 30, // Email
            'N' => 20, // Téléphone
            'O' => 20, // Handicap
            'P' => 25, // CIN Père
            'Q' => 30, // Nom Père
            'R' => 30, // Prénom Père
            'S' => 25, // Métier Père
            'T' => 25, // CIN Mère
            'U' => 30, // Nom Mère
            'V' => 30, // Prénom Mère
            'W' => 25, // Métier Mère
            'X' => 20, // Série
            'Y' => 25, // Année Bac
            'Z' => 20, // Note Bac
            'AA' => 20, // Mention Bac
            'AB' => 30, // Diplôme DEUG
            'AC' => 20, // Mention DEUG
            'AD' => 30, // Spécialité DEUG
            'AE' => 30, // Établissement DEUG
            'AF' => 25, // Ville Établissement DEUG
            'AG' => 25, // Date Obtention DEUG
            'AH' => 20, // Type Licence
            'AI' => 20, // Mention LP
            'AJ' => 30, // Spécialité LP
            'AK' => 30, // Établissement LP
            'AL' => 25, // Ville Établissement Licence
            'AM' => 25, // Date Obtention LP
            'AN' => 20, // Nombre Jours Stage
            'AO' => 20, // Fonctionnaire
            'AP' => 20, // Secteur
            'AQ' => 20, // Nombre Années
            'AR' => 20, // Poste
            'AS' => 25, // Lieu Travail
            'AT' => 25, // Ville Travail
            'AU' => 20, // Notes 1
            'AV' => 20, // Notes 2
            'AW' => 20, // Notes 3
            'AX' => 20, // Notes 4
            'AY' => 20, // Notes 5
            'AZ' => 20, // Notes 6
            'BA' => 30, // Path Photo
            'BB' => 30, // Path CIN
            'BC' => 30, // Path Note 1
            'BD' => 30, // Path Note 2
            'BE' => 30, // Path Note 3
            'BF' => 30, // Path Note 4
            'BG' => 30, // Path Note 5
            'BH' => 30, // Path Note 6
            'BI' => 30, // Path CV
            'BJ' => 25, // Filière
            'BK' => 25, // Filière Choix 1
            'BL' => 25, // Filière Choix 2
            'BM' => 25, // Filière Choix 3
            'BN' => 20, // Vérification
            'BO' => 25, // Motif
        ];
    }

}
