<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post("users/login", [UserController::class, 'login']);
Route::post("users/register", [UserController::class, 'add']);

Route::get("images/{image_name}", [RecipeController::class, 'getImage']);

Route::group([
    "middleware" => ["auth:api"]
], function () {
    Route::patch("users/check", function () { return response()->json(["message" => "User is still logged in"]); });
    Route::patch("users/logout", [UserController::class, 'logout']);
    Route::patch("users/refresh", [UserController::class, 'refresh']);

    Route::put("users/{user_id}/recipes/{recipe_id}", [UserController::class, 'likeRecipe']); // for liking a recipe
    Route::patch("users/{user_id}/recipes/{recipe_id}", [UserController::class, 'unlikeRecipe']); // for unliking a recipe

    Route::patch("recipes", [RecipeController::class, 'all']);
    Route::patch("recipes/{id}", [RecipeController::class, 'get']);
    Route::post("recipes", [RecipeController::class, 'add']);

    Route::patch("recipes/liked/{user_id}", [UserController::class, 'getLikedRecipes']);
    Route::patch("recipes/created/{user_id}", [UserController::class, 'getCreatedRecipes']);

    Route::delete("recipes/{id}", [RecipeController::class, 'delete']);
    Route::put("recipes/{id}", function () { return "Not implemented"; });
});
