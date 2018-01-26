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
Route::get('weixin/token', 'WeixinController@token');
Route::post('weixin/token', 'WeixinController@token');
Route::any('weixin/send', 'WeixinController@send');
Route::any('weixin/qigua', 'WeixinController@qigua');
Route::any('weixin/scws', 'WeixinController@scws');
Route::any('weixin/test', 'WeixinController@identifyTextCategory');
