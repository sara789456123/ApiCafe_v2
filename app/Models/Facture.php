<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facture extends Model
{
    protected $table = 'facture';

    protected $fillable = [
        'id_commande',
        'id_produit',
        'nb_produit',
        'prix_unitaire',
    ];

    public function dosette()
    {
        return $this->belongsTo(Dosettes::class, 'id_produit');
    }

    public $timestamps = false;

    /**
     * Facture appartient à une commande
     */
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'id_commande');
    }

    /**
     * Facture appartient à un produit (dosette)
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Dosettes::class, 'id_produit');
    }
}
