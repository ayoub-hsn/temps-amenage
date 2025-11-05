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
            'A' => 15, // CNE
            'B' => 15, // CIN
            'C' => 25, // Nom
            'D' => 25, // Prénom
            'E' => 30, // Email
            'F' => 20, // Téléphone
            'G' => 15, // Série de Bac
            'H' => 20, // Diplôme Bac+2
            'I' => 20, // Mention
            'J' => 25, // Spécialité du Diplome
            'K' => 30, // Etablissement
            'L' => 20, // Date Obtention du Diplôme
            'M' => 20, // Moyenne du Diplome
            'N' => 20, // Secteur
            'O' => 20, // Poste
            'P' => 25, // Filière
            'Q' => 20, // Vérification
            'R' => 25, // Motif
        ];
    }
}
