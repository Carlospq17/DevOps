<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::group(['prefix' => 'v1', 'middleware'=>'log.route'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login')->name('user.login');
        Route::post('register', 'ClientController@postClient')->name('user.register');
    });

    Route::group(['middleware'=>'jwt.verify','prefix'=>'users'],function () {
        Route::get('me', 'UserController@getCurrentUser')->name('user.me');
    });

    Route::group(['middleware'=>'jwt.verify','prefix'=>'clients'], function () {
        Route::get('{id}', 'ClientController@getClientById')->where(['id' => '[0-9]+']);
        Route::get('', 'ClientController@getClient')->name('client.all');
        
        Route::put('{id}', 'ClientController@putClient')->where(['id' => '[0-9]+'])->name('client.update');

        Route::delete('{id}', 'ClientController@deleteClient')->where(['id' => '[0-9]+'])->name('client.delete');
    });

    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'sales'], function () {
        Route::get('{id}', 'SaleController@getSaleById')->where(['id' => '[0-9]+']);
        Route::get('', 'SaleController@getSale')->name('sale.all');

        Route::put('{id}', 'SaleController@putSale')->where(['id' => '[0-9]+'])->name('sale.update');

        Route::post('client/{clientId}', 'SaleController@postSale')->where(['clientId' => '[0-9]+'])->name('sale.create');

        Route::delete('{id}', 'SaleController@deleteSale')->where(['id' => '[0-9]+'])->name('sale.delete');
    });

    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'products'], function () {
        Route::get('{id}', 'ProductController@getProductById')->where(['id' => '[0-9]+']);
        Route::get('', 'ProductController@getProduct')->name('product.all');

        Route::put('{id}', 'ProductController@putProduct')->where(['id' => '[0-9]+'])->name('product.update');

        Route::post('product/', 'ProductController@postProduct')->name('product.register');

        Route::delete('{id}', 'ProductController@deleteProduct')->where(['id' => '[0-9]+'])->name('product.delete');
    });

    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'sales_products'], function () {
        Route::get('{id}', 'SalesProductsController@getSaleProductById')->where(['id' => '[0-9]+']);
        Route::get('', 'SalesProductsController@getSaleProduct')->name('sales_products.all');;

        Route::put('{id}', 'SalesProductsController@putSaleProduct')->where(['id' => '[0-9]+'])->name('sales_products.update');

        Route::post('sale_product/', 'SalesProductsController@postSaleProduct')->name('sales_products.register');

        Route::delete('{id}', 'SalesProductsController@deleteSaleProduct')->where(['id' => '[0-9]+'])->name('sales_products.delete');
    });
});