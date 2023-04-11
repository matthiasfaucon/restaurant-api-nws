<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredient::class, 'recipes_ingredients', 'recipe_id', 'ingredients_id')
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
