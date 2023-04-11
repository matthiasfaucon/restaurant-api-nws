<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Jenssegers\Mongodb\Eloquent\Model;

class recipeNoSql extends Model
{
    protected $connection = 'mongodb';

    use HasFactory;

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(IngredientNoSql::class, 'recipes_ingredients', 'recipe_id', 'ingredients_id')
            ->as('recette_ingredient')
            ->withTimestamps();
    }

    protected $fillable = [
        'titre',
        'image',
        'description'
    ];

    public function getRouteKeyName(): string
    {
        return 'titre';
    }
}
