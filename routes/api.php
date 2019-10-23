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

