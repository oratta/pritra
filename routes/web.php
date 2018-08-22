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

Route::get('sample/vue2', function (){
    return view('sample.vue2');
});
