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

Route::get('/', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function (){
    Route::get('/member/detail', 'MemberController@index');
    Route::get('/profile/edit', 'MemberController@index');
    Route::post('/member/edit', 'MemberController@edit');
    Route::post('/organizer/edit', 'OrganizerController@edit');
    Route::post('/vendor/edit', 'VendorController@edit');
});



Route::get('/product/type', 'ProductTypeController@index');
Route::get('/product/type/edit/{id}', 'ProductTypeController@editForm');
Route::post('/product/type', 'ProductTypeController@store');
Route::get('/product/type/add', 'ProductTypeController@addForm');
Route::post('/product/type/{id}', 'ProductTypeController@update');
Route::post('/product/type/{id}/delete', 'ProductTypeController@destroy');

Route::get('/products', 'ProductController@index')->name('allProducts');

Route::get('product/search', 'ProductController@search')->name('searchProducts');
Route::get('product/{id}/detail', 'ProductController@detail');
Route::get('products/vendor/{id}','ProductController@indexByVendorId')->name('productsByVendor');
Route::prefix('product')->middleware(['auth','organizer'])->group(function () {
    Route::get('add', 'ProductController@addForm')->name('productAdd');
    Route::post('add', 'ProductController@store')->name('productStore');
    Route::get('{id}', 'ProductController@editForm');
    Route::post('{id}', 'ProductController@update')->name('productUpdate');
    Route::post('{id}/delete', 'ProductController@destroy');
});

Route::post('/cart/product/{id}', 'CartController@store');
//TODO add by auth token
Route::get('/cart', 'CartController@index')->name('cartProduct');
Route::post('/cart/checkout', 'TransactionProductController@checkout');

Route::get('/transaction', 'TransactionProductController@index')->name('allTransactions');
Route::post('/transaction/{id}/status', 'TransactionProductController@changeTransactionStatus');
Route::get('/event/cart', 'EventCartController@index')->name('cartEvents');

Route::get('/promo/check', 'PromoController@check');

Route::post('/cart/event/checkout', 'EventCartController@checkout');
Route::post('/cart/event/{id}', 'EventCartController@store');

Route::prefix('promo')->group(function () {
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
Route::prefix('event')->group(function () {
    Route::get('organizer/{id}', 'EventController@getEventByOrganizer')->name('eventsByOrganizer');
    Route::get('edit/{id}', 'EventController@editForm');
    Route::get('add', 'EventController@addForm');
    Route::post('{id}', 'EventController@update');
    Route::get('{id}/detail', 'EventController@detail')->name('eventDetail');
    Route::post('/', 'EventController@store');
    Route::get('/', 'EventController@index')->name('events');
    Route::get('location', 'EventController@getProvinces');
    Route::post('{id}/delete', 'EventController@destroy');
    Route::get('search', 'EventController@search')->name('searchEvents');
});

Route::prefix('role')->middleware('guest')->group(function (){
    Route::prefix('form')->group(function (){
        Route::view('member','regis-role.member')->name('roleFormMember');
        Route::view('vendor','regis-role.vendor')->name('roleFormVendor');
        Route::view('organizer','regis-role.organizer')->name('roleFormOrganizer');
    });
    Route::prefix('regis')->group(function (){
        Route::post('member','MemberController@create')->name('roleRegisMember');
        Route::post('vendor','VendorController@create')->name('roleRegisVendor');
        Route::post('organizer','OrganizerController@create')->name('roleRegisOrganizer');
    });
});

