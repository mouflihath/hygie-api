<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
class Patient extends Model
{
    use HasFactory;
use HasApiTokens, Notifiable;
    public function user()
{
    return $this->belongsTo(User::class);
}

public function commandes()
{
    return $this->hasMany(Commande::class);
}

public function ordonnances()
{
    return $this->hasMany(Ordonnance::class);
}

protected $fillable = [
        'user_id', 'telephone', 'adresse'
    ];

    protected $hidden = [
        'password'
    ];


}
