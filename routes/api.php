<?php

use App\Http\Controllers\UrlShortnerController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('url-shortner', [UrlShortnerController::class, 'store']);
Route::get('url-shortner/{urlShortner}', [UrlShortnerController::class, 'show']);

Route::prefix('short')->group(function () {
    Route::get('url-shortner/{urlShortner}', [UrlShortnerController::class, 'show']);
});
