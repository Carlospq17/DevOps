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


Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
    });

    Route::group(['middleware'=>'jwt.verify','prefix'=>'users'],function () {
        Route::get('me', 'UserController@getCurrentUser');
    });

    Route::group(['middleware'=>'jwt.verify','prefix'=>'clients'], function () {
        Route::get('{id}', 'ClientController@getClientById')->where(['id' => '[0-9]+']);
        Route::get('', 'ClientController@getClient');
        
        Route::put('{id}', 'ClientController@putClient')->where(['id' => '[0-9]+']);

        Route::post('', 'ClientController@postClient');

        Route::delete('{id}', 'ClientController@deleteClient')->where(['id' => '[0-9]+']);
    });

    Route::group(['middleware' => 'jwt.verify', 'prefix' => 'sales'], function () {
        Route::get('{id}', 'SaleController@getSaleById')->where(['id' => '[0-9]+']);
        Route::get('', 'SaleController@getSale');

        Route::put('{id}', 'SaleController@putSale')->where(['id' => '[0-9]+']);

        Route::post('client/{clientId}', 'SaleController@postSale')->where(['clientId' => '[0-9]+']);

        Route::delete('{id}', 'SaleController@deleteSale')->where(['id' => '[0-9]+']);
    });
});