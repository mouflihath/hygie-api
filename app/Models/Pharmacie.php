<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacie extends Model
{
    use HasFactory;

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

}
