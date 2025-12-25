<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentMaster extends Model
{
    use HasFactory,Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'CNE',
        'CIN',
        'nom',
        'prenom',
        'nomar',
        'prenomar',
        'datenais',
        'sexe',
        'payschamp',
        'villenais',
        'villechamp',
        'adresse',
        'email',
        'phone',

        'filiere',
        'filiere_choix_1',
        'filiere_choix_2',
        'filiere_choix_3',

        'serie',

        'typelicence',
        'etblsmtLp',
        'specialitelp',
        'date_obtention_LP',
        'mentionlp',
        'moyenne_licence',

        

        'secteur',
        'lieutravail',
        'villetravail',
        'poste',

    

        'user_id',
        'confirmation_student',

        'etablissement_id',
        
        'verif',
        'motif'
    ];

    public function etablissement(){
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }

    public function filiereMaster()
    {

        // Check if student belongs to an etablissement
        if ($this->etablissement && $this->etablissement->multiple_choix_filiere_master == 1) {
            // Check in order of priority which filiere choice is set
            if ($this->filiere_choix_1) {
                return $this->belongsTo(Filiere::class, 'filiere_choix_1');
            } elseif ($this->filiere_choix_2) {
                return $this->belongsTo(Filiere::class, 'filiere_choix_2');
            } elseif ($this->filiere_choix_3) {
                return $this->belongsTo(Filiere::class, 'filiere_choix_3');
            }
        }

        // Default case if multiple choices are not enabled
        return $this->belongsTo(Filiere::class, 'filiere');
    }


    public function filiereBac()
    {
        // If 'multiple_choix_filiere' is 1, check if student belongs to one of the choices
        if ($this->etablissement && $this->etablissement->multiple_choix_filiere == 1) {
            // Check if the student's filiere choices match any of the three choices
            if (in_array($this->id, [$this->filiere_choix_1, $this->filiere_choix_2, $this->filiere_choix_3])) {
                return $this->belongsTo(Filiere::class, 'filiere');
            }
        }

        // If 'multiple_choix_filiere' is 0, return the default 'filiere' relationship
        return $this->belongsTo(Filiere::class, 'filiere');
    }




    // public function filiereMaster()
    // {
    //     dd($this->filiere);
    //     // If 'multiple_choix_filiere_master' is 1, check if student belongs to one of the choices
    //     if ($this->etablissement && $this->etablissement->multiple_choix_filiere_master == 1) {
    //         // Check if the student's filiere choices match any of the three choices
    //         if (in_array($this->id, [$this->filiere_choix_1, $this->filiere_choix_2, $this->filiere_choix_3])) {
    //             return $this->belongsTo(Filiere::class, 'filiere');
    //         }
    //     }

    //     // If 'multiple_choix_filiere' is 0, return the default 'filiere' relationship
    //     return $this->belongsTo(Filiere::class, 'filiere');
    // }

    


    public function getEtablissementId()
    {
        $filiere = $this->filiere()->first();
        return $filiere ? $filiere->etablissement_id : null;
    }

}
