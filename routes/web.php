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

Route::get('/parse', function() {
    $kata = App\Katum::where('bahasa_id', 1)->orderBy('id','asc')->get();
    echo "[";
    foreach($kata as $key => $value) {
        if($key != 0) {
            echo ",";
        }
        echo "'".$value->kata."' ";
    }
    echo "]";
});

Route::get('/data', function() {
    ini_set('max_execution_time', -1);
    $output = json_decode(file_get_contents(storage_path("/app/public/sunda.json")),true);
    foreach($output as $kata) {
        $k = App\Katum::find($kata['id'])->id;
        if(App\Katum::find($kata['id'])->kata != $kata['kata']) {
            $kt = App\Katum::create([
                "kata" => $kata['kata'],
                "bahasa_id" => 2,
                "contoh_kalimat" => ""
            ]);
            $tr = App\Translate::create([
                "dari" => $kata['id'],
                "tujuan" => $kt->id,
                "user_id" => 1,
                "rate" => 0
            ]);
        }
    }
});

Route::Get('test', function() {
    $translate = App\Translate::find(24414);
    $output = $translate->rated;
    dd($output);
});
