<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

//Route::prefix('movies')->controller(MoviesController::class)->group(function () {
//    Route::match(['get', 'head'],'{}', 'index');
//    Route::post('', 'store');
//    Route::match(['put', 'patch'], '{id}', 'update');
//    Route::get('{id}', 'show');
//    Route::delete('{id}', 'destroy');
//});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'movies' => \App\Http\Controllers\Api\MovieController::class,
        'categories' => \App\Http\Controllers\Api\CategoryController::class,
    ]);
});