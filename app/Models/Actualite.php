<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Actualite extends Model
{
    use HasFactory,Notifiable;

    protected $fillable=  [
        'image',
        'titre',
        'description',
        'user_id',
        'published_at',
        'finished_at'
    ];
    

    public function owner(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
