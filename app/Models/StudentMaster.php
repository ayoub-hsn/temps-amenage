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
        'villechamp',//en arabe
        'adresse',
        'email',
        'phone',



        'serie',
        'Anneebac',

        'dernier_diplome_obtenu',// bac+3; bac+4; bac+5
        'type_diplome_obtenu',//privee; public; autre
        'specialitediplome',
        'ville_etablissement_diplome',
        'date_optention_diplome',




        'fonctionnaire',
        'secteur',
        'nombreannee',
        'poste',
        'lieutravail',
        'villetravail',




        'path_photo',
        'path_cin',
        'path_bac',
        'path_licence',
        'path_attestation_non_emploi',
        'path_cv',




        'filiere',
        'filiere_choix_1',
        'filiere_choix_2',
        'filiere_choix_3',



       'etablissement_id',

        'verif',
        'motif',
        'user_id',

        'confirmation_student',
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
