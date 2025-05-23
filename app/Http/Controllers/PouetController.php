<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosettes;

class PouetController extends Controller
{

    public function allDosette()
    {
    
        $dosettes = Dosettes::with('marque:id,nom', 'pays:id,nom')
            ->select('id', 'nom', 'intensite', 'prix', 'id_marque', 'id_pays')
            ->get()
            ->map(function ($dosette) {
                return [
                    'id' => $dosette->id,
                    'nom' => $dosette->nom,
                    'intensite' => $dosette->intensite,
                    'prix' => $dosette->prix,
                    'marque' => $dosette->marque->nom,
                    'pays' => $dosette->pays->nom,
                ];
            });

      
        return response()->json($dosettes);
    }

  public function sortDosettesByName(Request $request)
  {
      $order = $request->get('order', 'asc'); // Valeur par défaut : asc
  
      if (!in_array(strtolower($order), ['asc', 'desc'])) {
          return response()->json(['error' => 'Le paramètre "order" doit être "asc" ou "desc".'], 400);
      }

    $dosettes = Dosettes::with('marque:id,nom', 'pays:id,nom')
        ->orderBy('nom', $order)
        ->get()
        ->map(function ($dosette) {
            return [
                'id' => $dosette->id,
                'nom' => $dosette->nom,
                'intensite' => $dosette->intensite,
                'prix' => $dosette->prix,
                'marque' => $dosette->marque->nom,
                'pays' => $dosette->pays->nom,
            ];
        });

    return response()->json($dosettes);
}

    public function store(Request $request)
    {
      
        $request->validate([
            'nom' => 'required|string|max:100',
            'intensite' => 'required|integer',
            'prix' => 'required|numeric',
            'id_marque' => 'required|exists:marque,id',
            'id_pays' => 'required|exists:pays,id',
        ]);

    
        $dosette = Dosettes::create($request->all());

     
        return response()->json($dosette, 201);
    }
    
  public function update(Request $request, $id)
  {
    
      $dosette = Dosettes::findOrFail($id);
  
      //return var_dump($dosette);
    
     /*
      $request->validate([
          'nom' => 'required|string',
          'intensite' => 'required|integer',
          'prix' => 'required|numeric',
          'id_marque' => 'required|exists:marque,id',
          'id_pays' => 'required|exists:pays,id',
      ]);
      */
  
  
      $dosette->update($request->all());
  
     
      $dosette->load('marque:id,nom', 'pays:id,nom');
  
     
      $dosetteData = [
          'id' => $dosette->id,
          'nom' => $dosette->nom,
          'intensite' => $dosette->intensite,
          'prix' => $dosette->prix,
          'marque' => $dosette->marque->nom,
          'pays' => $dosette->pays->nom,
      ];
      
      //return "coucou";
    //return vardump($dosetteData);
     return response()->json($dosetteData);
  }


    public function destroy($id)
    {
        
        $dosette = Dosettes::findOrFail($id);

        
        $dosette->delete();

       
        return response()->json(null, 204);
    }
    
     public function show($id)
    {
        $dosette = Dosettes::with('marque:id,nom', 'pays:id,nom')
            ->select('id', 'nom', 'intensite', 'prix', 'id_marque', 'id_pays')
            ->findOrFail($id);
    
        return response()->json([
            'id' => $dosette->id,
            'nom' => $dosette->nom,
            'intensite' => $dosette->intensite,
            'prix' => $dosette->prix,
            'marque' => $dosette->marque->nom,
            'pays' => $dosette->pays->nom,
        ]);
    }



    public function filterDosettes(Request $request)
    {
        $query = Dosettes::with('marque:id,nom', 'pays:id,nom');

 
        if ($request->has('prixMin')) {
            $query->where('prix', '>=', $request->prixMin);
        }
        if ($request->has('prixMax')) {
            $query->where('prix', '<=', $request->prixMax);
        }
        if ($request->has('intensiteMin')) {
            $query->where('intensite', '>=', $request->intensiteMin);
        }
        if ($request->has('intensiteMax')) {
            $query->where('intensite', '<=', $request->intensiteMax);
        }
        if ($request->has('pays')) {
            $query->whereHas('pays', function ($q) use ($request) {
                $q->where('nom', $request->pays);
            });
        }
        if ($request->has('continent')) {
            $query->whereHas('pays.continent', function ($q) use ($request) {
                $q->where('nom', $request->continent);
            });
        }
        if ($request->has('marque')) {
            $query->whereHas('marque', function ($q) use ($request) {
                $q->where('nom', $request->marque);
            });
        }

      
        $dosettes = $query->get()->map(function ($dosette) {
            return [
                'id' => $dosette->id,
                'nom' => $dosette->nom,
                'intensite' => $dosette->intensite,
                'prix' => $dosette->prix,
                'marque' => $dosette->marque->nom,
                'pays' => $dosette->pays->nom,
            ];
        });

        return response()->json($dosettes);
    }
}
