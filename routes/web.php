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


Route::get('/', 'HomeController@index');
Route::post('/do_result', 'HomeController@do_result');
Route::get('/get_result', 'HomeController@get_result');
Route::get('/list', 'HomeController@getList');
Route::get('/ai/train', 'AiController@train');
Route::post('/ai/save', 'AiController@train');
Route::get('/ai/learn', 'AiController@learn');


