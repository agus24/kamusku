<?php

use Illuminate\Http\Request;

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
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, X-XSRF-TOKEN, Authorization, Cache-Control');
header('Access-Control-Allow-Methods: GET,PUT,POST,PATCH,DELETE');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('bahasa', "Api\\BahasaController");
Route::resource('kata', "Api\\KataController");
Route::get('getTranslate', "TranslateController@getTranslateData");
Route::get('loadTranslate', 'HomeController@load');
Route::post('like', "TranslateController@like");
Route::post('loadComment', "TranslateController@loadComment");
Route::post('postComment', "TranslateController@postComment");
Route::post('getKata', "TranslateController@getKata");

Route::get('getNotif', 'NotificationController@index');
