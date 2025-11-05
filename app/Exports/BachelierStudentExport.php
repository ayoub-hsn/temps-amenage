<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class BachelierStudentExport implements FromView, WithColumnWidths
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
        return view('exports.students_bachelier', [
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
            'H' => 20, // Moyenne du Bac
            'I' => 20, // Secteur
            'J' => 20, // Poste
            'K' => 25, // Filière
            'L' => 20, // Vérification
            'M' => 25, // Motif
        ];
    }
}
