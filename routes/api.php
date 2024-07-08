<?php

use App\Http\Controllers\RecipeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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
Route::post("user/login", function () { return "Not implemented"; });
Route::post("user/register", function () { return "Not implemented"; });

Route::group([
    // auth middleware later
], function () {
    Route::get("users/check", function () { return "Not implemented"; });
    Route::get("users/logout", function () { return "Not implemented"; });

    Route::put("users/{user_id}/recipes/{recipe_id}", [UserController::class, 'likeRecipe']); // for liking a recipe
    Route::delete("users/{user_id}/recipes/{recipe_id}", [UserController::class, 'unlikeRecipe']); // for unliking a recipe

    Route::get("recipes", [RecipeController::class, 'all']);
    Route::get("recipes/{id}", [RecipeController::class, 'get']);
    Route::post("recipes", [RecipeController::class, 'add']);

    Route::get("recipes/liked/{user_id}", [UserController::class, 'getLikedRecipes']);
    Route::get("recipes/created/{user_id}", [UserController::class, 'getCreatedRecipes']);

    Route::delete("recipes/{id}", [RecipeController::class, 'delete']);
    Route::put("recipes/{id}", function () { return "Not implemented"; });
});
