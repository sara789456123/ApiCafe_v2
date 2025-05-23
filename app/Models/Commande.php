<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commande extends Model
{
    protected $table = 'commande';
    
    protected $fillable = ['id_utilisateur', 'prixTTC', 'date_facturation'];


    public $timestamps = false; // Car pas de created_at / updated_at

    protected $dates = [
        'date_facturation',
    ];

    /**
     * Commande appartient à un utilisateur
     */
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur');
    }


    /**
     * Une commande a plusieurs factures (lignes produits)
     */
    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class, 'id_commande');
    }
}
