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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('decode', function() {
    ini_set('max_execution_time', -1);
    $dec = App\decoder::all();
    foreach($dec as $key => $value) {
        $op = App\decoder::find($value->_id);
        // dd($op);
        $op->output = html_entity_decode($value->artikata);
        $op->save();
    }
});
