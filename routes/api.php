<?php

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
    Route::get("user/check", function () { return "Not implemented"; });
    Route::get("user/logout", function () { return "Not implemented"; });

    Route::put("user/{user_id}/recipe/{recipe_id}", function () { return "Not implemented"; }); // for liking a recipe

    Route::get("recipes", function () { return "Not implemented"; });
    Route::get("recipe/{id}", function () { return "Not implemented"; });
    Route::post("recipe", function () { return "Not implemented"; });

    Route::get("recipes/liked/{user_id}", function () { return "Not implemented"; });
    Route::get("recipes/created/{user_id}", function () { return "Not implemented"; });

    // later aditions 

    Route::put("recipe/{id}", function () { return "Not implemented"; });
    Route::delete("recipe/{id}", function () { return "Not implemented"; });

});
