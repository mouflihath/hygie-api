<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    use HasFactory;

    protected $fillable = [
        'pharmacie_id',
        'livreur_id',
        'nom_client',
        'adresse_livraison',
        'status'
    ];

    public function pharmacie() {
        return $this->belongsTo(Pharmacie::class);
    }

    public function livreur() {
        return $this->belongsTo(Livreur::class);
    }
}
