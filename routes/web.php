<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::resource('ads', 'AdController');
Route::post('favorites', 'AdController@storeFavorite');
Route::delete('favorites/{adId}', 'AdController@destroyFavorite');
Route::get('favorites', 'AdController@showFavorite')->name('ads.favorite');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');
