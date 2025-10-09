<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Etablissement extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'nom',
        'nom_abrev',
        'description',
        'logo',
        'responsable_id',
        'multiple_choix_filiere',//bac
        'multiple_choix_filiere_passerelle',//passerelle
        'multiple_choix_filiere_master',//master
        'bac_accee_ouvert_ouvert',
        'bac_accee_regule_ouvert',
        'passerelle_ouvert',
        'master_ouvert',
        'show_cin_input_master',
        'show_photo_input_master',
        'show_cv_input_master',
        'show_bac_input_master',
        'show_licence_input_master',
        'show_attestation_no_emploi_input_master',
        'show_cin_input_passerelle',
        'show_photo_input_passerelle',
        'show_cv_input_passerelle',
        'show_bac_input_passerelle',
        'show_diplome_deug_input_passerelle',
        'show_attestation_no_emploi_input_passerelle',
        'show_cin_input_bac_acceeouvert',
        'show_photo_input_bac_acceeouvert',
        'show_cv_input_bac_acceeouvert',
        'show_bac_input_bac_acceeouvert',
        'show_cin_input_bac_acceeregule',
        'show_photo_input_bac_acceeregule',
        'show_cv_input_bac_acceeregule',
        'show_bac_input_bac_acceeregule'
    ];
    public function responsable(){
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function serie_bac(){
        return $this->belongsToMany(SerieBac::class, 'etablissements_series_bacs','etablissement_id','serie_bac_id');
    }

    public function diplomebacplus2(){
        return $this->belongsToMany(DiplomBac2::class, 'etablissement_dibplome_bac_plus2s','etablissement_id','diplome_bac_2_id');
    }

    public function filiere(){
        return $this->hasMany(Filiere::class, 'etablissement_id');
    }

    public function filiereMaster()
    {
        return $this->hasMany(Filiere::class, 'etablissement_id')
                    ->where('type', 1) // 1 = master
                    ->where('active', 1);
    }

    public function filiereLicence()
    {
        return $this->hasMany(Filiere::class, 'etablissement_id')
                    ->where('type', 2)  // 2 = licence
                    ->where('active', 1);
    }

    public function studentMaster(){
        return $this->hasMany(StudentMaster::class, 'etablissement_id');
    }

    public function studentPasserelle(){
        return $this->hasMany(StudentPasserelle::class, 'etablissement_id');
    }
}
