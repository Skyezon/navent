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
Route::get('/product/add', 'ProductController@addForm');
Route::post('/product/add', 'ProductController@store');
Route::get('/product/{id}', 'ProductController@editForm');
Route::post('/product/{id}', 'ProductController@update');
Route::post('/product/{id}/delete', 'ProductController@destroy');

Route::get('event/{id}','EventController@detail')->name('eventDetail');
