<?php

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

Route::get('/', "HomeController@index");


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::resource('bahasa', 'BahasaController');
Route::resource('kata', "KataController");
Route::resource('translate', "TranslateController")->except('create','store');
Route::get('translate/create/{bahasa_id}', "TranslateController@create");
Route::post('translate/create/{bahasa_id}', "TranslateController@store");

Route::get('bahasa/follow/{id}', "BahasaController@follow");
Route::get('bahasa/unfollow/{id}', "BahasaController@unfollow");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile/{user}', 'ProfileController@index');
Route::get('profile/{user}/edit', 'ProfileController@edit');
Route::post('profile/{user}', 'ProfileController@update');
