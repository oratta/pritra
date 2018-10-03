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

/*
Route::get('/{any}', function () {
//    return view('workOut.app');
    return view('sample.vue');
})->where('any','.*');
*/

//Route::get('sample/vue2', function (){
//    return view('sample.vue2');
//});
Route::get('/', 'WorkOutController@index');

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'WorkOutController@index');

    Route::prefix('workout')->group(function () {
        Route::get('/', 'WorkOutController@index');
        Route::get('index', 'WorkOutController@index');

        Route::get('create', 'WorkOutController@create');
        Route::post('store', 'WorkOutController@store');
    });

    Route::prefix('menus')->group(function () {
        Route::get('/', 'MenuController@index');
        Route::get('index', 'MenuController@index');
        Route::get('show/{id}', 'MenuController@show');
    });

    Route::prefix('steps')->group(function () {
        Route::get('/', 'StepController@index');
        Route::get('index', 'StepController@index');
        Route::get('show/{id}', 'StepController@show');
    });
});






Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('test/firebase', 'FirebaseTestController@tests');