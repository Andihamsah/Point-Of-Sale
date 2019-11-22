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

Route::get('user', 'UserController@getAuthenticatedUser')->middleware('jwt.verify');

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');

Route::group(['middleware' => ['cekrole:1']], function(){
    Route::post('register/kasir', 'UserController@registerKasir')->name('register.kasir');
    Route::post('login/kasir', 'UserController@loginKasir')->name('login.kasir');
    Route::put('update', 'UserController@update');
    Route::put('privasi', 'UserController@updateprivasi');
    Route::get('showkasir', 'UserController@index');
    Route::delete('deletekasir/{id}', 'UserController@deletekasir');
});