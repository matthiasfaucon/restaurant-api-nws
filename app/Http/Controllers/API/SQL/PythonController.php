<?php

namespace App\Http\Controllers\API\SQL;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * @OA\GET(
 * path="/api/get-datas",
 * tags={"Python - SQL"},
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
class PythonController extends Controller
{
    public function getDatas()
    {
        shell_exec('python ../scrapper-datas.py');
    }

    public function runScript(Request $request)
    {

        $output = file_get_contents(public_path('scrapper-datas/datas.json'));
        $output = json_decode($output, true);

        foreach ($output["ingredients"] as $ingredient) {
            Ingredient::updateOrCreate(
                ['nom' => $ingredient],
                [
                    'nom' => $ingredient
                ]
            );
        }

        foreach ($output["recipes"] as $recipe) {
            $recette = Recipe::updateOrCreate(
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

                $ing = Ingredient::where('nom', $ingredient)->first();

                $recette->ingredients()->attach($ing->id);
            }
        }

        return response()->json([
            'message' => 'success'
        ]);
    }
}
