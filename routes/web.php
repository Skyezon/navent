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

Route::get('/', function (){return route('events');})->name('home');


Route::get('/member/detail', 'MemberController@index');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/product/type', 'ProductTypeController@index');
Route::get('/product/type/edit/{id}', 'ProductTypeController@editForm');
Route::post('/product/type', 'ProductTypeController@store');
Route::get('/product/type/add', 'ProductTypeController@addForm');
Route::post('/product/type/{id}', 'ProductTypeController@update');
Route::post('/product/type/{id}/delete', 'ProductTypeController@destroy');

Route::get('/products', 'ProductController@index');
Route::prefix('product')->group(function (){
    Route::get('search', 'ProductController@search');
    Route::get('add', 'ProductController@addForm');
    Route::post('add', 'ProductController@store');
    Route::get('{id}', 'ProductController@editForm');
    Route::get('{id}/detail', 'ProductController@detail');
    Route::post('{id}', 'ProductController@update');
    Route::post('{id}/delete', 'ProductController@destroy');
});

Route::post('/cart/product/{id}', 'CartController@store');
//TODO add by auth token
Route::get('/cart', 'CartController@index');
Route::post('/cart/checkout', 'TransactionProductController@checkout');
Route::get('/transaction', 'TransactionProductController@index');
Route::post('/transaction/{id}/status', 'TransactionProductController@changeTransactionStatus');
Route::get('/event/cart', 'EventCartController@index');

Route::get('/promo/check', 'PromoController@check');

Route::post('/cart/event/checkout', 'EventCartController@checkout');
Route::post('/cart/event/{id}', 'EventCartController@store');

Route::prefix('promo')->group(function (){
    Route::get('/', 'PromoController@index');
    Route::get('edit/{id}', 'PromoController@editForm');
    Route::post('/', 'PromoController@store');
    Route::get('add', 'PromoController@addForm');
    Route::post('{id}', 'PromoController@update');
    Route::post('{id}/delete', 'PromoController@destroy');
});


Route::get('/event/type', 'EventTypeController@index');
Route::get('/event/type/edit/{id}', 'EventTypeController@editForm');
Route::post('/event/type', 'EventTypeController@store');
Route::get('/event/type/add', 'EventTypeController@addForm');
Route::post('/event/type/{id}', 'EventTypeController@update');
Route::post('/event/type/{id}/delete', 'EventTypeController@destroy');

//organizer id
    Route::prefix('event')->group(function (){
        Route::get('organizer/{id}', 'EventController@getEventByOrganizer');
        Route::get('edit/{id}', 'EventController@editForm');
        Route::get('add', 'EventController@addForm');
        Route::post('{id}', 'EventController@update');
        Route::get('{id}/detail', 'EventController@detail')->name('eventDetail');
        Route::post('/', 'EventController@store');
        Route::get('/', 'EventController@index')->name('events');
        Route::get('location', 'EventController@getProvinces');
        Route::post('{id}/delete', 'EventController@destroy');
        Route::get('search', 'EventController@search');
    });

