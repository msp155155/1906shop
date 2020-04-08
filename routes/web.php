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
<<<<<<< HEAD
Route::prefix('login')->group(function () {
    Route::get('/login', 'LoginController@login');
    Route::get('/loginDo', 'LoginController@loginDo');
});
=======

Route::get('reg','User\RegController@reg');
Route::post('doreg','User\RegController@doreg');
>>>>>>> 47fb6412a574eb90e785b111f3328e29fdc44a0d
