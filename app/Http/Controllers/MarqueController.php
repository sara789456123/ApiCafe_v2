<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Marque;

class MarqueController extends Controller
{
    public static function getmarque(){
        $requete = Marque::select('nom')
        ->orderBy("nom")
        ->get();
          return response()->json($requete);
    }
}
