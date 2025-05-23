<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'mdp' => 'required|string',
        ]);

        $utilisateur = Auth::where('login', $request->login)->first();

        if (!$utilisateur) {
            Log::info('User not found: ' . $request->login);
            return response()->json(['message' => 'Identifiants invalides'], 401);
        }

        if ($utilisateur->validatePassword($request->mdp)) {
            $token = $utilisateur->generateToken();
            return response()->json([
                'token' => $token,
            ], 200);
        }

        Log::info('Password validation failed for user: ' . $request->login);
        return response()->json(['message' => 'Identifiants invalides'], 401);
    }

    // Récupérer factures + produits par ID utilisateur
    public function getFacturesProduits($id)
    {
     $utilisateur = Auth::find($id);


        if (!$utilisateur) {
            return response()->json([
                'message' => "Utilisateur avec ID '$id' non trouvé."
            ], 404);
        }

        // Charger commandes avec factures et produits associés (eager loading)
        $commandes = $utilisateur->commandes()->with(['factures.produit'])->get();

        $data = [
            'id_utilisateur' => $utilisateur->id,
            'login' => $utilisateur->login,
            'factures' => []
        ];

      foreach ($commandes as $commande) {
    $factures = []; // on initialise à chaque commande

    foreach ($commande->factures as $facture) {
        $factures[] = [
            'id_produit' => $facture->id_produit,
            'nom_produit' => $facture->produit->nom ?? 'Produit inconnu',
            'nb_produit' => $facture->nb_produit,
            'prix_unitaire' => $facture->prix_unitaire,
            'prix_total_ttc' => $facture->prix_unitaire * $facture->nb_produit,
        ];
    }

    $data['factures'][] = [
        'id_commande' => $commande->id,
        'date_facturation' => \Carbon\Carbon::parse($commande->date_facturation)->toDateTimeString(),
        'prixTTC_commande' => $commande->prixTTC,
        'produits' => $factures,
    ];
}

        return response()->json($data);
    }

     
      public function updateAdresse(Request $request, $id)
      {
        // Validation des champs d'adresse
          $validated = $request->validate([
              'ville' => 'nullable|string|max:100',
              'rue' => 'nullable|string|max:255',
              'cp' => 'nullable|string|max:20',
              'pays' => 'nullable|string|max:100',
          ]);
      
          // Recherche de l'utilisateur
          $utilisateur = Auth::find($id);
      
          if (!$utilisateur) {
              return response()->json([
                  'message' => "Utilisateur avec l'ID '$id' non trouvé."
              ], 404);
          }
      
          // Mise à jour des champs d'adresse
          $utilisateur->update($validated);
      
          // Réponse JSON
          return response()->json([
              'message' => 'Adresse postale créée ou mise à jour avec succès.',
              'utilisateur' => [
                  'id' => $utilisateur->id,
                  'login' => $utilisateur->login,
                  'rue' => $utilisateur->rue,
                  'ville' => $utilisateur->ville,
                  'cp' => $utilisateur->cp,
                  'pays' => $utilisateur->pays,
              ]
          ]);
      }

    public function getAdresse($id)
    {
        $utilisateur = \App\Models\Auth::find($id);
    
        if (!$utilisateur) {
            return response()->json([
                'message' => "Utilisateur avec ID '$id' non trouvé."
            ], 404);
        }
    
        // Retourne uniquement les informations d'adresse
        return response()->json([
            'id' => $utilisateur->id,
            'ville' => $utilisateur->ville,
            'rue' => $utilisateur->rue,
            'cp' => $utilisateur->cp,
            'pays' => $utilisateur->pays,
        ]);
    }
    // Vérification token
    public function checkToken(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token non fourni'], 401);
        }

        $utilisateur = Auth::where('token', $token)->first();

        if (!$utilisateur) {
            return response()->json(['error' => 'Token invalide'], 401);
        }

        return response()->json([
            'message' => 'Token valide',
            'isAdmin' => $utilisateur->admin,
            'userId' => $utilisateur->id,
        ]);
    }
}
