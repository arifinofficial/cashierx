<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

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
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => ['role:admin']], function () {
        Route::resource('/setting', 'SettingController');
        Route::resource('/setting-printer', 'PrinterSettingController');
        Route::resource('/user', 'UserController');
        Route::resource('/role', 'RoleController');
        Route::get('/role-permission', 'RoleController@rolePermission')->name('roles.permission.index');
        Route::post('/role-permission', 'RoleController@storePermission')->name('roles.permission.store');
        Route::put('/role-permission/{role}', 'RoleController@setRolePermission')->name('roles.setRolePermission');
        
        // Report
        Route::group(['prefix' => 'report', 'as' => 'report.'], function () {
            Route::get('/daily-report', 'ReportController@dailyIndex')->name('daily.index');
            Route::get('/daily-generate', 'ReportController@generateDailyPdf')->name('daily.pdf');
        });

        // Transaction
        Route::resource('/transaction-data', 'TransactionDataController')->except(['store', 'create', 'update', 'edit']);
    });

    Route::get('/order-finish', function () {
        return view('order.finish');
    })->name('order.finish');

    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::resource('/category', 'CategoryController');
        Route::resource('/main-product', 'MainProductController');
        Route::resource('main-product.product', 'ProductController');
        Route::resource('/unit', 'UnitController');
        Route::resource('/variant', 'VariantController');
        Route::resource('/product-item', 'ProductItemController')->except(['index', 'create', 'store', 'show', 'edit', 'update']);
    });

    Route::get('/transaction', 'OrderController@index')->name('order.transaksi');
    Route::post('/transaction/checkout', 'OrderController@storeOrder')->name('order.store');

    Route::get('/api/product/{id}', 'OrderController@getProduct');
    Route::post('/api/cart', 'OrderController@addToCart');
    Route::get('/api/cart', 'OrderController@getCart');
    Route::get('/api/search', 'OrderController@search');
    Route::get('/api/products', 'OrderController@allProducts');
    Route::delete('/api/cart/{id}', 'OrderController@removeCart');
    Route::get('/api/category/product/{id}', 'OrderController@getProductByCategory');

    Route::get('/api/datatable/user', 'UserController@dataTable')->name('api.datatable.user');
    Route::get('/api/datatable/category', 'CategoryController@dataTable')->name('api.datatable.category');
    Route::get('/api/datatable/unit', 'UnitController@dataTable')->name('api.datatable.unit');
    Route::get('/api/datatable/variant', 'VariantController@dataTable')->name('api.datatable.variant');
    Route::get('/api/datatable/transaction-data', 'TransactionDataController@dataTable')->name('api.datatable.transaction-data');

    Route::get('/testing-qpos', function () {
        try {
            $ip = '192.168.111.11'; // IP Komputer kita atau printer lain yang masih satu jaringan
            $printer = 'EPSON TM-U220 Receipt'; // Nama Printer yang di sharing
            $connector = new WindowsPrintConnector("smb://" . $ip . "/" . $printer);
            $printer = new Printer($connector);
            $printer->initialize();
            $printer -> text("Email : Halo \n");
            $printer -> text("Testing : Test \n");
            $printer -> cut();
            $printer -> close();
        } catch (Exception $e) {
            $response = ['success'=>'false'];
        }
    })->name('qpos');
});
