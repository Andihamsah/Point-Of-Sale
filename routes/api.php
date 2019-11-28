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

Route::group(['prefix' => 'kasir','middleware' => ['cekrole:1']], function(){
    Route::post('register', 'UserController@registerKasir');
    Route::post('login', 'UserController@loginKasir');
    Route::put('update', 'UserController@update');
    Route::put('privasi', 'UserController@updateprivasi');
    Route::get('show/{store}', 'UserController@index');
    Route::delete('delete/{id}', 'UserController@deletekasir');
});

//Store
Route::post('store/tambah', 'StoreController@store');
Route::put('store/update/id', 'StoreController@update');
Route::get('store/show/id', 'StoreController@show');
Route::get('store/show', 'StoreController@index');
Route::delete('store/delete', 'StoreController@destroy');

// item
Route::post('barang', 'ItemController@produk');
Route::put('barang/update/{id}', 'ItemController@updateproduk');
Route::put('beli/{id}', 'ItemController@beli');
Route::get('tampil/{store}', 'ItemController@show');
Route::delete('barang/delete/{id}', 'ItemController@destroy');

// Kategori
Route::post('kategori', 'kategoriController@store');
Route::put('kategori/update/{id}', 'kategoriController@update');
Route::get('kategori/show', 'KategoriController@index');
Route::delete('kategori/delete/{id}', 'KategoriController@destroy');