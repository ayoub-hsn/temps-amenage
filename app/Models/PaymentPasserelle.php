<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentPasserelle extends Model
{
    use HasFactory,Notifiable,SoftDeletes;

    protected $fillable = [
        'student_id',
        'CNE',
        'CIN',
        'nom',
        'prenom',
        'email',
        'phone',
        'filiere',
        'date_inscription',
        'etat_payment',
        'montant_paye',
        'document'
    ];
}
