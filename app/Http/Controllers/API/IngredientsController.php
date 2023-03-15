<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Ingredients;
use Illuminate\Http\Request;

class IngredientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les utilisateurs
        $ingredients = Ingredients::all();

        // On retourne les informations des utilisateurs en JSON
        return response()->json($ingredients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // La validation de données
        // $this->validate($request, [
        //     'nom' => 'max:100'
        // ]);

        // On crée un nouvel ingredient
        $ingredient = Ingredients::create([
            'id' => $request->id,
            'nom' => $request->nom,
            'created_at' => $request->created_at
        ]);

        // On retourne les informations du nouvel utilisateur en JSON
        return response()->json($ingredient, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ingredients $ingredient)
    {
        // On retourne les informations de l'utilisateur en JSON
        return response()->json($ingredient);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ingredients $ingredient)
    {
        // La validation de données
        $this->validate($request, [
            'nom' => 'required|max:100'
        ]);

        // On modifie les informations de l'utilisateur
        $ingredient->update([
            "nom" => $request->name
        ]);

        // On retourne la réponse JSON
        return response()->json();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ingredients $ingredient)
    {
        // On supprime l'utilisateur
        $ingredient->delete();

        // On retourne la réponse JSON
        return response()->json();
    }
}
