<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'description', 'image', 'prix'];

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}