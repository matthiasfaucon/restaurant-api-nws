<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Ingredient extends Model
{
    use HasFactory;

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipes_ingredients', 'ingredients_id', 'recipe_id')
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
