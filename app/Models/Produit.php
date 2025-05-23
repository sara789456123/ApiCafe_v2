<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produit'; // ou 'produits' selon le nom exact de ta table
    public $timestamps = false;   // si pas de created_at / updated_at
}
