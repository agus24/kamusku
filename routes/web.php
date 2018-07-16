<?php

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
Route::get('terjemahan/{id}', 'HomeController@show');
Route::post('comment/{id}', 'HomeController@store');
Route::get('terjemahan/{id}/like', "HomeController@like");
Route::post('terjemahan/', "TranslateController@insertDB");

Route::get('/kirimUlang', function() {
    ini_set('max_execution_time', -1);
    if(Auth::guest()) {
        abort(404);
    }
    $user = Auth::user();
    \Mail::to($user->email)->send(new App\Mail\UserRegistered($user));
    return redirect()->back();
});

Route::get('aktivasi/{id}', function($id){
    $user = App\User::find($id);
    $user->status = 1;
    $user->save();
    echo "Akun anda telah di aktifkan.";
    echo "<script>setTimeout(function() {
        window.location.href = '".url('/')."'
    }, 2000);</script>";
});

Route::get('follow/{id}', "ProfileController@follow");
Route::get('unfollow/{id}', "ProfileController@unfollow");
Route::get('report/{id}', "HomeController@reportForm");
Route::post('report/{id}', "HomeController@report");

Route::get('test', function() {
    Auth::user()->notify(new \App\Notifications\LikeTranslate(1, App\User::find(2)));
});
