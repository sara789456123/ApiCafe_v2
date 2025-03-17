<?php
namespace App\Http\Controllers;

use App\Models\Pays;
use App\Models\Continent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class PaysController extends Controller
{
    public function AfficherPays()
    {
        if (isset($_GET["prix_min"])) {
            if (is_numeric($_GET["prix_min"])) {
                if (isset($_GET["prix_max"])) {
                    if (is_numeric($_GET["prix_max"])) {
                        $a = Pays::select("nom")->orderBy("nom")->get();
                        $b = Continent::select("nom")->orderBy("nom")->get();
                        $c = $a->concat($b); // Use concat to merge collections
                        return response()->json($c); // Convertir le résultat obtenu en JSON et l’affiche
                    }
                    $error = "Type de prix max errror !";
                    http_response_code(400);
                    return response()->json($error);
                }
            }
            $error = "Erreur: type de prix min errror !";
            http_response_code(400);
            return response()->json($error);
        }
    }

    public static function getpays()
    {
        $pays = Pays::join('continent', 'pays.id_continent', '=', 'continent.id')
            ->select('pays.nom as pays', 'continent.nom as continent')
            ->orderBy("pays.nom")
            ->get();
        return response()->json($pays);
    }

    public static function getPaysNames()
    {
        $pays = Pays::select('id', 'nom')
            ->orderBy("nom")
            ->get();
        return response()->json($pays);
    }
}
