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

Route::get('/', 'WorkoutController@index');
Route::get('workout/', 'WorkOutController@index');
Route::get('workout/index', 'WorkOutController@index');

Route::get('workout/create', 'WorkOutController@create');
Route::post('workout/store', 'WorkOutController@store');

Route::get('menus', 'MenuController@index');
Route::get('menus/index', 'MenuController@index');
Route::get('menus/show/{id}', 'MenuController@show');
Route::get('steps', 'StepController@index');
Route::get('steps/index', 'StepController@index');
Route::get('steps/show/{id}', 'StepController@show');

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('test/firebase', 'FirebaseTestController@tests');