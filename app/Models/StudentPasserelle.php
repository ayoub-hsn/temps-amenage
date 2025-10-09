<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentPasserelle extends Model
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

        'dernier_diplome_obtenu',// bac+2; bac+3; bac+4; bac+5
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
        'path_diplomedeug',
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

        'confirmation_student'
    ];

    public function etablissement(){
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }

    public function filierePasserelle()
    {
        // Check if student belongs to an etablissement
        if ($this->etablissement && $this->etablissement->multiple_choix_filiere_passerelle == 1) {
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
}
