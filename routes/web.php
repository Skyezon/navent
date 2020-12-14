<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/products', 'ProductController@index');
Route::get('/product/add', 'ProductController@addForm');
Route::post('/product/add', 'ProductController@store');
Route::get('/product/{id}', 'ProductController@editForm');
Route::post('/product/{id}', 'ProductController@update');
Route::post('/product/{id}/delete', 'ProductController@destroy');

Route::post('/cart/product/{id}', 'CartController@store');
//TODO add by auth token
Route::get('/cart', 'CartController@index');
Route::post('/cart/checkout', 'TransactionProductController@checkout');
Route::get('/transaction', 'TransactionProductController@index');

Route::get('/promo', 'PromoController@index');
Route::get('/promo/edit/{id}', 'PromoController@editForm');
Route::post('/promo', 'PromoController@store');
Route::get('/promo/add', 'PromoController@addForm');
Route::post('/promo/{id}', 'PromoController@update');
Route::post('/promo/{id}/delete', 'PromoController@destroy');
