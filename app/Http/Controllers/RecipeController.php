<?php

namespace App\Http\Controllers;

use App\Modules\Recipes\Services\RecipeService;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    protected $service;

    public function __construct(RecipeService $service)
    {
        $this->service = $service;
    }

    public function all(Request $request)
    {
        $search = $request->query('search', '');
        $category = $request->query('category', '');
        /* if adding pagination
        $page = $request->query('page', 1);
        $perPage = $request->query('per_page', 10);
        */

        $recipes = $this->service->allRecipes($search, $category);
        return response()->json($recipes);
    }
}
