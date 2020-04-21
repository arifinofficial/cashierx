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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/setting', 'SettingController');
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::resource('/category', 'CategoryController');
        Route::resource('/main-product', 'MainProductController');
        Route::resource('main-product.product', 'ProductController');
        Route::resource('/unit', 'UnitController');
        Route::resource('/variant', 'VariantController');
        Route::resource('/product-item', 'ProductItemController')->except(['index', 'create', 'store', 'show', 'edit', 'update']);
    });

    Route::get('/transaction', 'OrderController@addOrder')->name('order.transaksi');
    Route::get('/transaction/checkout', 'OrderController@storeOrder')->name('order.store');

    Route::get('/api/product/{id}', 'OrderController@getProduct');
    Route::post('/api/cart', 'OrderController@addToCart');
    Route::get('/api/cart', 'OrderController@getCart');
    Route::delete('/api/cart/{id}', 'OrderController@removeCart');

    Route::get('/api/datatable/category', 'CategoryController@dataTable')->name('api.datatable.category');
    Route::get('/api/datatable/unit', 'UnitController@dataTable')->name('api.datatable.unit');
    Route::get('/api/datatable/variant', 'VariantController@dataTable')->name('api.datatable.variant');
});
