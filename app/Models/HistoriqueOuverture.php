<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class HistoriqueOuverture extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'user_id',
        'action',
        'etablissement'
    ];
}
