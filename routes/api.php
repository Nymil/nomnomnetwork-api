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
Route::post("user/login", function () { return "Not implementer"; });
Route::post("user/register", function () { return "Not implementer"; });

Route::group([
    // auth middleware later
], function () {
    Route::get("user/check", function () { return "Not implementer"; });
    Route::get("user/logout", function () { return "Not implementer"; });

    Route::put("user/{user_id}/recipe/{recipe_id}", function () { return "Not implementer"; }); // for liking a recipe

    Route::get("recipes", function () { return "Not implementer"; });
    Route::get("recipe/{id}", function () { return "Not implementer"; });
    Route::post("recipe", function () { return "Not implementer"; });

    // later aditions 

    Route::put("recipe/{id}", function () { return "Not implementer"; });
    Route::delete("recipe/{id}", function () { return "Not implementer"; });

});
