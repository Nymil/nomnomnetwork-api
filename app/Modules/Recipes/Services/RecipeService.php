<?php

namespace App\Modules\Recipes\Services;

use App\Models\Recipe;
use App\Modules\Core\Services\Service;

class RecipeService extends Service {

    public function __construct(Recipe $model)
    {
        parent::__construct($model);
    }

}