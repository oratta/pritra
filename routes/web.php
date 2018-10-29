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
//    return view('workout.app');
    return view('sample.vue');
})->where('any','.*');
*/

//Route::get('sample/vue2', function (){
//    return view('sample.vue2');
//});
Route::get('/', 'WorkoutController@index');

Route::middleware(['auth'])->group(function () {
    Route::get('/', 'WorkoutController@index');

    Route::prefix('workout')->group(function () {
        Route::get('/', 'WorkoutController@index');
        Route::get('index', 'WorkoutController@index');

        Route::get('create/{recomend?}', 'WorkoutController@create');
        Route::post('store', 'WorkoutController@store');
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

Route::middleware(['adminCheck'])->group(function(){
    Route::prefix('admin')->group(function(){
        Route::get('index', 'AdminController@index');
        Route::get('/', 'AdminController@index');
        Route::post('add_user', 'AdminController@addUser');
    });
});



Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('test/firebase', 'FirebaseTestController@tests');