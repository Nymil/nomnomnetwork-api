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

Route::group([
    "middleware" => ["auth:api"]
], function () {
    Route::get("users/check", function () { return response()->json(["message" => "User is still logged in"]); });
    Route::get("users/logout", [UserController::class, 'logout']);
    Route::get("users/refresh", [UserController::class, 'refresh']);

    Route::put("users/{user_id}/recipes/{recipe_id}", [UserController::class, 'likeRecipe']); // for liking a recipe
    Route::delete("users/{user_id}/recipes/{recipe_id}", [UserController::class, 'unlikeRecipe']); // for unliking a recipe

    Route::get("recipes", [RecipeController::class, 'all']);
    Route::get("recipes/{id}", [RecipeController::class, 'get']);
    Route::post("recipes", [RecipeController::class, 'add']);

    Route::get("recipes/liked/{user_id}", [UserController::class, 'getLikedRecipes']);
    Route::get("recipes/created/{user_id}", [UserController::class, 'getCreatedRecipes']);

    Route::delete("recipes/{id}", [RecipeController::class, 'delete']);
    Route::put("recipes/{id}", function () { return "Not implemented"; });

    Route::get("images/{image_name}", [RecipeController::class, 'getImage']);
});
