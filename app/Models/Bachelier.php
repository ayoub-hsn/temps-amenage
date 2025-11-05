<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bachelier extends Model
{
    use HasFactory,Notifiable;

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
        'moyenne_bac',


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
}
