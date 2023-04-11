<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Jenssegers\Mongodb\Eloquent\Model;

class IngredientNoSql extends Model
{
    protected $connection = 'mongodb';
    use HasFactory;

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(recipeNoSql::class, 'recipes_ingredients', 'ingredients_id', 'recipe_id')
            ->as('recette_ingredient')
            ->withTimestamps();
    }

    protected $fillable = [
        'nom'
    ];

    public function getRouteKeyName(): string
    {
        return 'nom';
    }
}
