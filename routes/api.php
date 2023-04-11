<?php

use App\Http\Controllers\API\NOSQL\IngredientControllerNoSql;
use App\Http\Controllers\API\NOSQL\PythonControllerNoSql;
use App\Http\Controllers\API\NOSQL\RecipeControllerNoSql;
use App\Http\Controllers\API\SQL\IngredientController;
use App\Http\Controllers\API\SQL\PythonController;
use App\Http\Controllers\API\SQL\RecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'sql'], function () {
    Route::apiResource("ingredients", IngredientController::class);
    Route::apiResource("recipes", RecipeController::class);
    Route::get('recipes/ingredients/{ingredient}', [RecipeController::class, 'getRecipesByIngredient']);
    Route::get('get-datas',  [PythonController::class, 'getDatas']);
    Route::post('run-python',  [PythonController::class, 'runScript']);
});

Route::group(['prefix' => 'nosql'], function () {
    Route::apiResource("ingredients", IngredientControllerNoSql::class);
    Route::apiResource("recipes", RecipeControllerNoSql::class);
    Route::get('recipes/ingredients/{ingredient}', [RecipeControllerNoSql::class, 'getRecipesByIngredient']);
    Route::get('get-datas',  [PythonControllerNoSql::class, 'getDatas']);
    Route::post('run-python',  [PythonControllerNoSql::class, 'runScript']);
});
