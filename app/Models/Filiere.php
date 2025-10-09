<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filiere extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'nom_abrv',
        'nom_complet',
        'description',
        'document',
        'etablissement_id',
        'responsable_id',
        'type',//Master ou bien licence: 1=Master;2=Licence
        'active',

    ];

    public  const TYPE = [
        1 => "Master",
        2 => "Licence",
        // 3 => "Licence"
    ];


    public function etablissement()
    {
        return $this->belongsTo(Etablissement::class, 'etablissement_id'); // Assurez-vous que la clé étrangère est correcte
    }

    public function responsable(){
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function licenceExcellenceStudents()
    {
        if ($this->etablissement && $this->etablissement->multiple_choix_filiere_master == 1) {
            // Return a query builder with the dynamic conditions
            return StudentPasserelle::where(function ($query) {
                $query->where('filiere_choix_1', $this->id)
                    ->orWhere('filiere_choix_2', $this->id)
                    ->orWhere('filiere_choix_3', $this->id);
            });
        } else {
            // Return the default hasMany relationship
            return $this->hasMany(StudentPasserelle::class, 'filiere');
        }
    }


    public function masterStudents()
    {
        return $this->hasMany(StudentMaster::class, 'filiere')->where(function ($query) {
            if ($this->relationLoaded('etablissement') && $this->etablissement) {
                dd('hi');
                if ($this->etablissement->multiple_choix_filiere_master == 1) {
                    $query->where('filiere_choix_1', $this->id)
                        ->orWhere('filiere_choix_2', $this->id)
                        ->orWhere('filiere_choix_3', $this->id);
                }
            }
        });
    }


    public function provinces(){
        return $this->belongsToMany(Province::class, 'filiere_provinces','filiere_id','province_id');
    }


}
