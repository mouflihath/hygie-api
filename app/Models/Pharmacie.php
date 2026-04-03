<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Pharmacie extends Model
{
    use HasFactory;
use HasApiTokens, Notifiable;
    public function user()
{
    return $this->belongsTo(User::class);
}

public function stocks()
{
    return $this->hasMany(Stock::class);
}

public function commandes()
{
    return $this->hasMany(Commande::class);
}

protected $fillable = [
        'user_id', 'telephone', 'nom_pharmacie', 'adresse', 'ville', 'image', 'validee'
    ];

    protected $hidden = [
        'password'
    ];
}
