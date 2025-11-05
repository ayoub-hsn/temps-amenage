<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calendrier extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'etablissement_id',
        'date_debut_master',
        'date_fin_master',
        'date_debut_passerelle',
        'date_fin_passerelle',
        'date_debut_bachelier',
        'date_fin_bachelier'
    ];

    public function etablissement(){
        return $this->belongsTo(Etablissement::class, 'etablissement_id');
    }
}
