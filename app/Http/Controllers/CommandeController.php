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
        // Validation des données reçues
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
            return response()->json(['message' => 'Utilisateur non trouvé.'], 404);
        }

        // Crée la commande
         $dateFacturation = Carbon::now();

          $commande = Commande::create([
              'id_utilisateur' => $idUtilisateur,
              'prixTTC' => $validatedData['prixTTC'],
              'date_facturation' => $dateFacturation,
          ]);

        // Crée les factures liées
        foreach ($validatedData['produits'] as $produit) {
            Facture::create([
                'id_commande' => $commande->id,
                'id_produit' => $produit['id_produit'],
                'nb_produit' => $produit['nb_produit'],
                'prix_unitaire' => $produit['prix_unitaire'],
            ]);
        }

        // Retourne la commande créée
        return response()->json($commande, 201);
    }
}
