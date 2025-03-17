<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Marque;

class MarqueController extends Controller
{
    public function getmarque()
    {
        $marques = Marque::orderBy('nom', 'asc')->get();
        return response()->json($marques);
    }
}
