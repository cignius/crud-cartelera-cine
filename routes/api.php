<?php

use App\Http\Controllers\api\MovieController;
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

Route::get('peliculas', [MovieController::class, 'index'])->name('movie.index');
Route::get('pelicula/{token}', [MovieController::class, 'show'])->name('movie.show');

Route::fallback(function () {
    return abort(404, 'Not Found');
});
