<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SerieBac extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = ['nom'];


    public function etablissement(){
        return $this->belongsToMany(Etablissement::class, 'etablissements_series_bacs','serie_bac_id','etablissement_id');
    }
    
}
