<?php

namespace App\Http\Controllers\API\NOSQL;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\IngredientNoSql;
use App\Models\Recipe;
use App\Models\RecipeNoSql;
use Illuminate\Http\Request;

/** 
 * @OA\GET(
 *  path="/api/recipes",
 *  tags={"Recipes - NOSQL"},
 *  summary="Get list of recipes",
 *  description="Returns list of recipes",
 *  @OA\Response(
 *      response=200,
 *      description="Successful operation",
 *      @OA\JsonContent(
 *          @OA\Property(property="id", type="integer"),
 *          @OA\Property(property="titre", type="string"),
 *          @OA\Property(property="image", type="string"),
 *          @OA\Property(property="description", type="string"),
 *          @OA\Property(property="ingredients", type="array",
 *              @OA\Items(
 *                  type="object",
 *                  @OA\Property(property="id", type="integer"),
 *                  @OA\Property(property="nom", type="string"),
 *                  @OA\Property(property="created_at", type="string"),
 *                  @OA\Property(property="updated_at", type="string")
 *              ),
 *          ),
 *          @OA\Property(property="created_at", type="string"),
 *          @OA\Property(property="updated_at", type="string"),
 *      ),
 *  ),
 *  @OA\Response(
 *      response=404,
 *      description="Recipes not found"
 *  ),
 * )
 * 
 * @OA\GET(
 *  path="/api/recipes/{id}",
 *  tags={"Recipes"},
 *  summary="Get recipe information",
 *  description="Returns recipe data",
 *  operationId="show_recipe",
 *  @OA\Parameter(
 *      name="id",
 *      in="path",
 *      description="ID of recipe to return",
 *      required=true,
 *      @OA\Schema(
 *          type="integer"
 *      )
 *  ),
 *  @OA\Response(
 *      response=200,
 *      description="Successful operation",
 *      @OA\JsonContent(
 *          @OA\Property(property="id", type="integer"),
 *          @OA\Property(property="titre", type="string"),
 *          @OA\Property(property="image", type="string"),
 *          @OA\Property(property="description", type="string"),
 *          @OA\Property(property="ingredients", type="array",
 *              @OA\Items(
 *                  type="object",
 *                  @OA\Property(property="id", type="integer"),
 *                  @OA\Property(property="nom", type="string"),
 *                  @OA\Property(property="created_at", type ="string"),
 *                  @OA\Property(property="updated_at", type="string")
 *              ),
 *         ),
 *        @OA\Property(property="created_at", type="string"),
 *       @OA\Property(property="updated_at", type="string"),
 *     ),
 * ),
 * @OA\Response(
 *    response=404,
 *   description="Recipe not found"
 * ),
 * )
 * 
 */
class RecipeControllerNoSql extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // On retourne les informations des recettes en JSON avec les ingrédients associés
        $recipesNoSql = RecipeNoSql::with('ingredients')->get();

        // On retourne les informations des recettes en JSON avec les ingrédients associés
        // $allRecipes = $recipes->merge($recipesNoSql);

        return response()->json($recipesNoSql);
        // return response()->json($recipesNoSql->with('ingredients')->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // La validation de données
    //     // $this->validate($request, [
    //     //     'nom' => 'max:100'
    //     // ]);

    //     // On crée un nouvel Recipe
    //     foreach ($request->all() as $recipe) {
    //         Recipe::create([
    //             'titre' => $recipe['titre'],
    //             'image' => $recipe['image'],
    //             'ingredients_id' => $recipe['ingredient'],
    //             'description' => $recipe['description']
    //         ]);
    //         RecipeNoSql::create([
    //             'titre' => $recipe['titre'],
    //             'image' => $recipe['image'],
    //             'ingredients_id' => $recipe['ingredient'],
    //             'description' => $recipe['description']
    //         ]);
    //     }

    //     // On retourne les informations du nouvel utilisateur en JSON
    //     return response()->json($recipe, 201);
    // }

    public function getRecipesByIngredient($ingredient)
    {
        $ing = IngredientNoSql::where('id', $ingredient)->first();
        if (!$ing) {
            // Si l'ingrédient n'existe pas, retourner une réponse 404
            return response()->json(['message' => 'Ingrédient non trouvé'], 404);
        }

        // Récupérer les recettes qui contiennent cet ingrédient
        $recettes = $ing->recipes()->get();

        // Retourner la liste des recettes sous forme de réponse JSON
        return $recettes;
    }

    /**
     * Display the specified resource.
     */
    public function show(RecipeNoSql $recipe)
    {
        // On retourne les informations d'une recette en JSON avec ses ingrédients associés
        return response()->json($recipe->load('ingredients'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, RecipeNoSql $recipe)
    // {
    //     // La validation de données
    //     $this->validate($request, [
    //         'nom' => 'required|max:100'
    //     ]);

    //     // On modifie les informations de l'utilisateur
    //     $recipe->update([
    //         "nom" => $request->name
    //     ]);

    //     // On retourne la réponse JSON
    //     return response()->json();
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(RecipeNoSql $recipe)
    // {
    //     // On supprime l'utilisateur
    //     $recipe->delete();

    //     // On retourne la réponse JSON
    //     return response()->json();
    // }
}
