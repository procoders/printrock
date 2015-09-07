<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(array('prefix' => 'api/v1'), function()
{
    Route::get('/addons_type/all', 'Api\v1\AddonsTypeController@all');
    Route::get('/addons_type/get/{id}', 'Api\v1\AddonsTypeController@get');
    Route::get('/addon/all', 'Api\v1\AddonController@all');
    Route::get('/addon/get/{id}', 'Api\v1\AddonController@get');
    Route::get('/format/all', 'Api\v1\FormatController@all');
    Route::get('/format/get/{id}', 'Api\v1\FormatController@get');
    Route::get('/language/all', 'Api\v1\LanguageController@all');
    Route::get('/language/get/{id}', 'Api\v1\LanguageController@get');
    Route::get('/customer/get/{id}', 'Api\v1\CustomerController@get');
    Route::post('/customer/add', 'Api\v1\CustomerController@add');
    Route::get('/customers_address/get/{id}', 'Api\v1\CustomersAddressController@get');
    Route::post('/customers_address/add', 'Api\v1\CustomersAddressController@add');
    Route::post('/photo/add', 'Api\v1\PhotoController@add');
    Route::get('/orders_status/all', 'Api\v1\OrdersStatusController@all');
    Route::get('/orders_status/get/{id}', 'Api\v1\OrdersStatusController@get');
    Route::get('/order/get/{id}', 'Api\v1\OrderController@get');
    Route::post('/order/add', 'Api\v1\OrderController@add');

});
