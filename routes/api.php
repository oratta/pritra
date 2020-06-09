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


//メニューのプランニング画面。すでにプランがあったらそっちを返す
Route::get('menu', 'MenuController@indexUserMenu')->name('show_user_menu');

//プランの決定。
Route::post('plan', 'WorkoutSetController@setPlan')->name('workout_set.set_plan');
//プランを表示
Route::get('plan', 'WorkoutSetController@showPlan')->name('workout_set.show_plan');
//実行したワークアウトの記録
Route::post('workout_set', 'WorkoutSetController@add')->name('workout_set.add');
//履歴の表示(最後に実行したワークアウトの情報)
Route::get('workout_set', 'WorkoutSetController@showHistory')->name('workout_set.history');

//auth
Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

//user
Route::get('/user', function () {
    return Auth::user();
})->name('user');