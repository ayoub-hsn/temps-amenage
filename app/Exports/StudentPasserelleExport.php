<?php

namespace App\Exports;

use App\Models\StudentPasserelle;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class StudentPasserelleExport implements FromView, WithColumnWidths
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
        return view('exports.students_passerelle', [
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
            'AH' => 20, // Nombre Jours Stage
            'AI' => 20, // Fonctionnaire
            'AJ' => 20, // Secteur
            'AK' => 20, // Nombre Années
            'AL' => 20, // Poste
            'AM' => 25, // Lieu Travail
            'AN' => 25, // Ville Travail
            'AO' => 20, // Notes 1
            'AP' => 20, // Notes 2
            'AQ' => 20, // Notes 3
            'AR' => 20, // Notes 4
            'AS' => 30, // Path Photo
            'AT' => 30, // Path CIN
            'AU' => 30, // Path Note 1
            'AV' => 30, // Path Note 2
            'AW' => 30, // Path Note 3
            'AX' => 30, // Path Note 4
            'AY' => 30, // Path CV
            'AZ' => 25, // Filière
            'BA' => 25, // Filière Choix 1
            'BB' => 25, // Filière Choix 2
            'BC' => 25, // Filière Choix 3
            'BD' => 20, // Vérification
            'BE' => 25, // Motif
        ];
        
    }
}
