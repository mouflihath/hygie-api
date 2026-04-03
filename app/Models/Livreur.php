<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Livreur extends Model
{
    use HasFactory;
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'user_id', 'telephone', 'vehicule', 'matricule', 'statut'
    ];

    protected $hidden = [
        'password'
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}
