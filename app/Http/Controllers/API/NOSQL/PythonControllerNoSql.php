<?php

namespace App\Http\Controllers\API\NOSQL;

use App\Http\Controllers\Controller;
use App\Models\IngredientNoSql;
use App\Models\recipeNoSql;

/**
 * @OA\GET(
 * path="/api/get-datas",
 * tags={"Python - NOSQL"},
 * summary="Create JSON File",
 * description="Create JSON File, with datas from python scrapper",
 * operationId="getDatas",
 * @OA\Response(
 * response=200,
 * description="Successful operation",
 * ),
 * @OA\Response(
 * response=404,
 * description="Not found"
 * ),
 * ),
 * 
 * @OA\POST(
 * path="/api/run-python",
 * tags={"Python"},
 * summary="Run python script",
 * description="Run python script, and save datas in database",
 * operationId="runScript",
 * @OA\Response(
 * response=200,
 * description="Successful operation",
 * ),
 * @OA\Response(
 * response=404,
 * description="Not found"
 * ),
 * ),
 * 
 * 
 */
class PythonControllerNoSql extends Controller
{
    public function getDatas()
    {
        shell_exec('python ../scrapper2.py');
    }

    public function runScript()
    {
        $output = file_get_contents(public_path('datas.json'));
        $output = json_decode($output, true);
        // xr($output);
        // xr($output["recipes"]);

        foreach ($output["ingredients"] as $ingredient) {
            IngredientNoSql::updateOrCreate(
                ['nom' => $ingredient],
                [
                    'nom' => $ingredient
                ]
            );
        }

        foreach ($output["recipes"] as $recipe) {
            $recetteNoSql = recipeNoSql::updateOrCreate(
                ['titre' => $recipe['titre']],
                [
                    'titre' => $recipe['titre'],
                    'image' => $recipe['image'],
                    'description' => $recipe['description']
                ]
            );

            $ingredients = $recipe['ingredient'];

            xr($ingredients);

            foreach ($ingredients as $ingredient) {
                $ingNoSql = IngredientNoSql::where('nom', $ingredient)->first();
                // xr($ing);
                $recetteNoSql->ingredients()->attach($ingNoSql->id);
            }

            recipeNoSql::updateOrCreate(
                ['titre' => $recipe['titre']],
                [
                    'titre' => $recipe['titre'],
                    'image' => $recipe['image'],
                    'ingredients_id' => $recipe['ingredient'],
                    'description' => $recipe['description']
                ]
            );
        }

        return response()->json([
            'message' => 'success'
        ]);
    }
}
