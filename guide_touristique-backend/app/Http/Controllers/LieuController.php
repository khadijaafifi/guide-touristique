<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lieu;  
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\log;
class LieuController extends Controller
{
    // Méthode pour récupérer la liste des lieux
    public function index()
    {
        $lieux = Lieu::all();
        return response()->json($lieux);
    }
    public function show($id)
{
    $lieu = Lieu::findOrFail($id);
    return response()->json($lieu);
}

public function update(Request $request, $id)
{
    $lieu = Lieu::findOrFail($id);
   log::info("Tentative de modification du lieu ID: " . $id);
    $validated = $request->validate([
        'nom' => 'required|string|max:255',
        'description' => 'required|string|max:1000',
        'categorie' => 'required|string',
        'adresse' => 'required|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    $lieu->update($validated);

    if ($request->hasFile('image')) {
        if ($lieu->image) {
            Storage::delete('public/' . $lieu->image);
        }
        $lieu->image = $request->file('image')->store('images', 'public');
        $lieu->save();
    }

    return response()->json(['status' => 'success', 'lieu' => $lieu]);
}



    // Méthode pour ajouter un nouveau lieu
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'categorie' => 'required|string',
            'adresse' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // Création d'un nouveau lieu
        $lieu = new Lieu();
        $lieu->nom = $validated['nom'];
        $lieu->description = $validated['description'];
        $lieu->categorie = $validated['categorie'];
        $lieu->adresse = $validated['adresse'];

        // Gestion de l'image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $lieu->image = $path;
        } else {
            $lieu->image = null;
        }
        
        Log::info('Données reçues :', [
            'textes' => $request->except('image'),
            'image' => $request->file('image')
        ]);
        
        // Sauvegarde du lieu dans la base de données
        $lieu->save();

        // Retourner la réponse avec le lieu ajouté
        return response()->json(['status' => 'success', 'lieu' => $lieu], 201);
        
    }

    // Méthode pour supprimer un lieu
    public function destroy($id)
{
    $lieu = Lieu::find($id);
    if (!$lieu) {
        return response()->json(['message' => 'Lieu non trouvé'], 404);
    }

    // Supprimer l'image du stockage si nécessaire
    if ($lieu->image) {
        Storage::delete('public/' . $lieu->image);
    }

    $lieu->delete();

    return response()->json(['message' => 'Lieu supprimé'], 200);
    

}


} 
