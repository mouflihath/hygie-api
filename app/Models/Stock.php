<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    public function pharmacie()
{
    return $this->belongsTo(Pharmacie::class);
}
protected $fillable = ['pharmacie_id', 'medicament_id', 'quantite', 'prix'];
public function medicament()
{
    return $this->belongsTo(Medicament::class);
}

}
