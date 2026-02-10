<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    use HasFactory;

    public function commande()
{
    return $this->belongsTo(Commande::class);
}

public function medicament()
{
    return $this->belongsTo(Medicament::class);
}

}
