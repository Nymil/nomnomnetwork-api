<?php

namespace App\Http\Controllers;

use App\Modules\Users\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function getCreatedRecipes(Request $request, $user_id)
    {
        $user = $this->service->get($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $recipes = $this->service->getCreatedRecipes($user);
        return response()->json($recipes);
    }
}
