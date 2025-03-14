<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosettes;
use App\Models\Marque;
use App\Models\Pays;


class PouetController extends Controller
{

    public function allDosette()
    {
        // Fetch all dosettes with selected fields and related marque and pays information
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

        // Return the dosettes as a JSON response
        return response()->json($dosettes);
    }
        public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'nom' => 'required|string|max:100',
            'intensite' => 'required|integer',
            'prix' => 'required|numeric',
            'id_marque' => 'required|exists:marque,id',
            'id_pays' => 'required|exists:pays,id',
        ]);
    
        // Check if the marque and pays exist
        if (!Marque::existeMarque($request->id_marque) || !Pays::existePays($request->id_pays)) {
            return response()->json(['error' => 'Marque or Pays does not exist'], 404);
        }
    
        // Create a new dosette
        $dosette = Dosettes::create($request->all());
    
        // Return a success message along with the created dosette data
        return response()->json([
            'message' => 'Dosette créée avec succès',
            'dosette' => $dosette
        ], 201);
    }


    public function update(Request $request, $id)
  {
      // Validate the request data
      $request->validate([
          'nom' => 'required|string|max:100',
          'intensite' => 'required|integer',
          'prix' => 'required|numeric',
          'marque' => 'required|string|exists:marque,nom',
          'pays' => 'required|string|exists:pays,nom',
      ]);
  
      // Resolve marque and pays names to their IDs
      $marque = Marque::where('nom', $request->marque)->firstOrFail();
      $pays = Pays::where('nom', $request->pays)->firstOrFail();
  
      // Find the dosette by ID
      $dosette = Dosettes::findOrFail($id);
  
      // Update the dosette with the resolved IDs
      $dosette->update([
          'nom' => $request->nom,
          'intensite' => $request->intensite,
          'prix' => $request->prix,
          'id_marque' => $marque->id,
          'id_pays' => $pays->id,
      ]);
  
      // Load related data
      $dosette->load('marque:id,nom', 'pays:id,nom');
  
      // Prepare the response data
      $dosetteData = [
          'id' => $dosette->id,
          'nom' => $dosette->nom,
          'intensite' => $dosette->intensite,
          'prix' => $dosette->prix,
          'marque' => $dosette->marque->nom,
          'pays' => $dosette->pays->nom,
      ];
  
      // Return a success message along with the updated dosette data
      return response()->json([
          'message' => 'Dosette mise à jour avec succès',
          'dosette' => $dosetteData
      ], 200);
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

        // Apply filters based on query parameters
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

        // Execute the query and map the results
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
