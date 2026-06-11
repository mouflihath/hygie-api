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

// Pour accéder directement aux médicaments via le stock
public function medicaments()
{
    return $this->belongsToMany(Medicament::class, 'stocks')
                ->withPivot('quantite', 'prix')
                ->withTimestamps();
}

public function commandes()
{
    return $this->hasMany(Commande::class);
}

public function expeditions() {
    return $this->hasMany(Expedition::class);
}

public function livreurs()
{
    // Une pharmacie possède plusieurs livreurs
    return $this->hasMany(Livreur::class);
}
protected $fillable = [
        'user_id', 'telephone', 'nom_pharmacie', 'adresse', 'ville', 'image', 'validee'];

    protected $hidden = [
        'password'
    ];
}
