<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
// 注册
Route::get('reg','User\RegController@reg');
Route::post('doreg','User\RegController@doreg');

// 找回密码
Route::get('findpass','User\FindpassController@getFind');
Route::post('findpass','User\FindpassController@postFind');
// 重置密码
Route::get('resetpass','User\FindpassController@getReset');
Route::post('resetpass','User\FindpassController@postReset');

