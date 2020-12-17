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



Auth::routes();

Route::get('/', 'EventController@index')->name('home');

Route::get('/products', 'ProductController@index');
Route::get('/product/search', 'ProductController@search');
Route::get('/product/add', 'ProductController@addForm');
Route::post('/product/add', 'ProductController@store');
Route::get('/product/{id}', 'ProductController@editForm');
Route::get('/product/{id}/detail', 'ProductController@detail');
Route::post('/product/{id}', 'ProductController@update');
Route::post('/product/{id}/delete', 'ProductController@destroy');

Route::post('/cart/product/{id}', 'CartController@store');
//TODO add by auth token
Route::get('/cart', 'CartController@index');
Route::post('/cart/checkout', 'TransactionProductController@checkout');
Route::get('/transaction', 'TransactionProductController@index');
Route::get('/event/cart', 'EventCartController@index');

Route::post('/cart/event/checkout', 'EventCartController@checkout');
Route::post('/cart/event/{id}', 'EventCartController@store');

Route::get('/promo', 'PromoController@index');
Route::get('/promo/edit/{id}', 'PromoController@editForm');
Route::post('/promo', 'PromoController@store');
Route::get('/promo/add', 'PromoController@addForm');
Route::post('/promo/{id}', 'PromoController@update');
Route::post('/promo/{id}/delete', 'PromoController@destroy');


//organizer id
Route::get('/event/organizer/{id}', 'EventController@getEventByOrganizer');
Route::get('/event/edit/{id}', 'EventController@editForm');
Route::get('/event/add', 'EventController@addForm');
Route::post('/event/{id}', 'EventController@update');
Route::get('/event/{id}/detail', 'EventController@detail');
Route::post('/event', 'EventController@store');
Route::get('/event', 'EventController@index');
Route::get('/event/location', 'EventController@getProvinces');
Route::post('/event/{id}/delete', 'EventController@destroy');
Route::get('/event/search', 'EventController@search');
