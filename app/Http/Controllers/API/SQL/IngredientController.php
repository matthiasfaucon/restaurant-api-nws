<?php

namespace App\Http\Controllers\API\SQL;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\IngredientNoSql;
use Illuminate\Http\Request;


/**
 * 
 * @OA\Get(
 *  path="/api/ingredients",
 *  tags={"Ingredients - SQL"},
 *  summary="Get list of ingredients",
 *  description="Returns list of ingredients",
 *  @OA\Response(
 *      response=200,
 *      description="Successful operation",
 *      @OA\JsonContent(
 *          @OA\Property(property="id", type="integer"),
 *          @OA\Property(property="nom", type="string"),
 *          @OA\Property(property="created_at", type="string"),
 *          @OA\Property(property="updated_at", type="string"),
 *      ),
 *  ),
 * @OA\Response(
 * response=404,
 * description="Ingredient not found"
 * ),
 * ),
 * 
 * @OA\GET(
 * path="/api/ingredients/{id}",
 * tags={"Ingredients"},
 * summary="Get ingredient information",
 * description="Returns ingredient data",
 * operationId="show_ingredient",
 * @OA\Parameter(
 * name="id",
 * in="path",
 * description="ID of ingredient to return",
 * required=true,
 * @OA\Schema(
 * type="integer"
 * )
 *  ),
 * @OA\Response(
 * response=200,
 * description="Successful operation",
 * @OA\JsonContent(
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="nom", type="string"),
 * @OA\Property(property="created_at", type="string"),
 * @OA\Property(property="updated_at", type="string"),
 * ),
 * ),
 * @OA\Response(
 * response=404,
 * description="Ingredient not found"
 * ),
 * ),
 *
 *
 * 
 * 
 **/

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // On récupère tous les utilisateurs
        $ingredients = Ingredient::all();

        // On retourne les informations des utilisateurs en JSON
        return response()->json($ingredients);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // ! comment mettre des validators sur le nom de l'ingredient quand il y a plusieurs ingrédients dans le tableau
    //     // Validator::make($request->all(), [
    //     //     'nom' => 'required|unique:ingredients|max:255',
    //     // ])->validate();

    //     foreach ($request->all() as $ingredient) {
    //         Ingredient::create([
    //             'nom' => $ingredient['nom'],
    //         ]);
    //         IngredientNoSql::create([
    //             'nom' => $ingredient['nom'],
    //         ]);
    //     }

    //     // On retourne les informations du nouvel ingrédient en JSON
    //     return response()->json($request->all());
    // }

    /**
     * Display the specified resource.
     */
    public function show(Ingredient $ingredient)
    {
        // On retourne les informations de l'utilisateur en JSON
        return response()->json($ingredient);
    }
    // /**
    //  * Update the specified resource in storage.
    //  */
    // public function update(Request $request, Ingredient $ingredient)
    // {
    //     // La validation de données
    //     $this->validate($request, [
    //         'nom' => 'required|max:100'
    //     ]);

    //     // On modifie les informations de l'utilisateur
    //     $ingredient->update([
    //         "nom" => $request->name
    //     ]);

    //     // On retourne la réponse JSON
    //     return response()->json();
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  */
    // public function destroy(Ingredient $ingredient)
    // {
    //     // On supprime l'utilisateur
    //     $ingredient->delete();

    //     // On retourne la réponse JSON
    //     return response()->json();
    // }
}
