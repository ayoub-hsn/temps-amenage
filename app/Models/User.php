<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'telephone',
        'email',
        'password',
        'role_id',//1 = Sup Admin  ;  2 = Admin Etablissement  ; 3 = Admin filiere  ;  4  =  etudiant
        'active',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function role(){
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function etablissements(){
        return $this->hasMany(Etablissement::class, 'responsable_id');
    }

    public function etablissement(){
        return $this->hasOne(Etablissement::class, 'responsable_id');
    }


    public function filiere(){
        return $this->hasOne(Filiere::class, 'responsable_id');
    }

    public function actualites(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
