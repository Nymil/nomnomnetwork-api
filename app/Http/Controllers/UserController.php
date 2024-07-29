<?php

namespace App\Http\Controllers;

use App\Modules\Users\Services\UserService;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Contracts\Providers\JWT;
use Tymon\JWTAuth\Facades\JWTAuth;

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

    public function getLikedRecipes(Request $request, $user_id)
    {
        $user = $this->service->get($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $recipes = $this->service->getLikedRecipes($user);
        return response()->json($recipes);
    }

    public function likeRecipe(Request $request, $user_id, $recipe_id) {
        $user = $this->service->get($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $recipe = $this->service->likeRecipe($user, $recipe_id);

        if (!$recipe) {
            return response()->json(['error' => 'Recipe not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($recipe);
    }

    public function unlikeRecipe(Request $request, $user_id, $recipe_id) {
        $user = $this->service->get($user_id);

        if (!$user) {
            return response()->json(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $recipe = $this->service->unlikeRecipe($user, $recipe_id);

        if (!$recipe) {
            return response()->json(['error' => 'Recipe not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($recipe);
    }

    public function add(Request $request) {
        $data = $request->all();
        $user = $this->service->add($data);

        if ($this->service->hasErrors()) {
            return response()->json(['error' => 'Invalid data', 'errors' => $this->service->getErrors()], Response::HTTP_BAD_REQUEST);
        }

        return response()->json(["message" => "user registered successfuly"], Response::HTTP_CREATED);
    }

    public function login(Request $request) {
        $data = $request->all();

        // data validation
        $ruleKey = 'login';
        $this->service->validate($data, $ruleKey);
        if ($this->service->hasErrors()) {
            return response()->json(['error' => 'Invalid data', 'errors' => $this->service->getErrors()], Response::HTTP_BAD_REQUEST);
        }

        $token = JWTAuth::attempt([
            'name' => $data['name'],
            'password' => $data['password']
        ]);

        if (empty($token)) {
            return response()->json(["message" => "Invalid credentials"], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json([
            "message" => "Login successful",
            "token" => $token,
            "user_id" => JWTAuth::user()->id, 
            "username" => $data['name']
        ]);
    }

    public function refreshToken() {
        $newToken = JWTAuth::refresh();

        return response()->json(["message" => "Token refresh successfull", "token" => $newToken]);
    }

    public function logout() {
        JWTAuth::invalidate();

        return response()->json(["message" => "Logout successfull"]);
    }
}
