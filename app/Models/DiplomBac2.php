<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiplomBac2 extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = ['nom'];


    public function etablissement(){
        return $this->belongsToMany(Etablissement::class, 'etablissement_dibplome_bac_plus2s','diplome_bac_2_id','etablissement_id');
    }
}
