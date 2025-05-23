<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Commande;
use App\Models\Facture;
use App\Models\Auth;
use Carbon\Carbon;


class CommandeController extends Controller
{
    public function enregistrerCommande(Request $request, $idUtilisateur)
    {
        // Validation des donn�es re�ues
        $validatedData = $request->validate([
        'prixTTC' => 'required|numeric',
        'produits' => 'required|array',
        'produits.*.id_produit' => 'required|exists:dosette,id',
        'produits.*.nb_produit' => 'required|integer|min:1',
        'produits.*.prix_unitaire' => 'required|numeric|min:0',
          ]);

        // Cherche l'utilisateur
        $utilisateur = Auth::find($idUtilisateur);

        if (!$utilisateur) {
            return response()->json(['message' => 'Utilisateur non trouv�.'], 404);
        }

        // Cr�e la commande
         $dateFacturation = Carbon::now();

          $commande = Commande::create([
              'id_utilisateur' => $idUtilisateur,
              'prixTTC' => $validatedData['prixTTC'],
              'date_facturation' => $dateFacturation,
          ]);

        // Cr�e les factures li�es
        foreach ($validatedData['produits'] as $produit) {
            Facture::create([
                'id_commande' => $commande->id,
                'id_produit' => $produit['id_produit'],
                'nb_produit' => $produit['nb_produit'],
                'prix_unitaire' => $produit['prix_unitaire'],
            ]);
        }

        // Retourne la commande cr��e
        return response()->json($commande, 201);
    }
}
