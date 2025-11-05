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
        'villechamp',
        'adresse',
        'email',
        'phone',


        'filiere',
        'filiere_choix_1',
        'filiere_choix_2',
        'filiere_choix_3',


        'serie',


        'secteur',
        'lieutravail',
        'villetravail',
        'poste',


        'diplomedeug',
        'specialitedeug',
        'etblsmtdeug',
        'date_obtention_deug',
        'mentiondeug',
        'moyenne_deug',


        'user_id',
        'confirmation_student',

        'etablissement_id',
        
        
        'verif',
        'motif'
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
