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
            'A' => 15, // CNE
            'B' => 15, // CIN
            'C' => 25, // Nom
            'D' => 25, // Prénom
            'E' => 30, // Email
            'F' => 20, // Téléphone
            'G' => 15, // Série de Bac
            'H' => 20, // Type de licence
            'I' => 20, // Mention de Licence
            'J' => 25, // Spécialité du Licence
            'K' => 30, // Etablissement
            'L' => 25, // Ville d'établissement
            'M' => 20, // Date Obtention du Diplôme
            'N' => 20, // Moyenne du Licence
            'O' => 20, // Secteur
            'P' => 20, // Poste
            'Q' => 25, // Filière
            'R' => 20, // Vérification
            'S' => 25, // Motif
        ];
    }

}
