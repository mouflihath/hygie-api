<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    public function patient()
{
    return $this->belongsTo(Patient::class);
}

public function pharmacie()
{
    return $this->belongsTo(Pharmacie::class);
}

public function livreur()
{
    return $this->belongsTo(Livreur::class);
}

public function lignes()
{
    return $this->hasMany(LigneCommande::class);
}

public function paiement()
{
    return $this->hasOne(Paiement::class);
}

}
