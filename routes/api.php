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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function(){
    Route::get('list', 'WorkoutController@list');
});

//ワークアウト候補の取得
Route::get('workout_sets', 'WorkoutSetController@index');


////ワークアウトの記録
//Route::post('workouts')->name('workouts.post');
//
//
////ワークアウト履歴
////※ 検索クエリで取得件数などを調整する
//Route::get('workout_sets');
//
////ワークアウト目標の決定
//Route::put('workout_sets');


Route::get('menu', function(){return;});//メニューのプランニング画面
Route::post('plan', 'WorkoutSetController@setPlan');//プランの決定
Route::get('plan', function(){return;});//プランを表示
Route::post('workout_set', function(){return;});//実行したワークアウトの記録
Route::get('workout_set', function(){return;});//履歴の表示

//auth
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

//user
Route::get('/user', function () {
    return Auth::user();
})->name('user');