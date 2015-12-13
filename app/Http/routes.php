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
    Route::get('/addons_types/', 'Api\v1\AddonsTypeController@all');
    Route::get('/addons_types/{id}', 'Api\v1\AddonsTypeController@get');
    Route::get('/addons/', 'Api\v1\AddonController@all');
    Route::get('/addons/{id}', 'Api\v1\AddonController@get');
    Route::get('/formats/', 'Api\v1\FormatController@all');
    Route::get('/formats/{id}', 'Api\v1\FormatController@get');
    Route::get('/languages/', 'Api\v1\LanguageController@all');
    Route::get('/languages/{id}', 'Api\v1\LanguageController@get');
    Route::get('/customers/{id}', 'Api\v1\CustomerController@get');
    Route::post('/customers/', 'Api\v1\CustomerController@add');
    Route::post('/customers/login', 'Api\v1\CustomerController@login');
    Route::get('/customers_address/{id}', 'Api\v1\CustomersAddressController@get');
    Route::post('/customers_address/', 'Api\v1\CustomersAddressController@add');
    Route::post('/photos/add', 'Api\v1\PhotoController@add');
    Route::get('/orders_status/', 'Api\v1\OrdersStatusController@all');
    Route::get('/orders_status/{id}', 'Api\v1\OrdersStatusController@get');
    Route::get('/orders/{id}', 'Api\v1\OrderController@get');
    Route::post('/orders/', 'Api\v1\OrderController@add');
});
