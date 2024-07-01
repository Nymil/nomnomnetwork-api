<?php

namespace App\Modules\Recipes\Services;

use App\Models\Recipe;
use App\Modules\Core\Services\Service;

class RecipeService extends Service {

    public function __construct(Recipe $model)
    {
        parent::__construct($model);
    }

    public function allRecipes($search, $category) {
        $query = $this->model->query();

        $query->where('name', 'like', "%$search%");
        
        $possibleCategories = ['appatisers', 'starters', 'maindishes', 'desserts'];
        if (in_array($category, $possibleCategories)) {
            $query->where('category', $category);
        }

        return $query->get();
    }
}