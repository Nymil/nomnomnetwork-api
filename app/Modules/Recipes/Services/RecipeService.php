<?php

namespace App\Modules\Recipes\Services;

use App\Models\Recipe;
use App\Modules\Core\Services\Service;
use Illuminate\Support\Facades\DB;

class RecipeService extends Service {

    public function __construct(Recipe $model)
    {
        parent::__construct($model);
    }

    private function addCreatorToRecipe($recipe) {
        $recipe->creator = DB::table('users')->where('id', $recipe->creator_id)->value('name');
        return $recipe;
    }
    
    public function allRecipes($search, $category) {
        $query = $this->model->query();

        $query->where('name', 'like', "%$search%");
        
        $possibleCategories = ['appatisers', 'starters', 'maindishes', 'desserts'];
        if (in_array($category, $possibleCategories)) {
            $query->where('category', $category);
        }

        $returnData = $query->get();
        
        // we only need the creator name, the name of the recipe and the image url
        return $returnData->map(function ($recipe) {
            $recipe = $this->addCreatorToRecipe($recipe);
            return [
                'name' => $recipe->name,
                'creator' => $recipe->creator,
                'image_url' => $recipe->image_url,
            ];
        });
    }
}