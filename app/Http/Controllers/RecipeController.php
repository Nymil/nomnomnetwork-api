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
}
