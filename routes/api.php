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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth'])->group(function () {
    Route::post('/favorites/ads/{ad}/toggle', 'Api\FavoriteController@toggleFavorite')
        ->name('toggle-favorite');
    Route::post('/subscribe/', 'Api\SubscriptionController@subscribe')
        ->name('toggle-subscribe');
});
