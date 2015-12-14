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
    Route::group(array('prefix' => 'addons_types'), function()
    {
        Route::get('/', 'Api\v1\AddonsTypeController@all');
        Route::get('/{id}', 'Api\v1\AddonsTypeController@get');
    });

    Route::group(array('prefix' => 'addons'), function()
    {
        Route::get('/', 'Api\v1\AddonController@all');
        Route::get('/{id}', 'Api\v1\AddonController@get');
    });

    Route::group(array('prefix' => 'formats'), function()
    {
        Route::get('/', 'Api\v1\FormatController@all');
        Route::get('/{id}', 'Api\v1\FormatController@get');
    });

    Route::group(array('prefix' => 'languages'), function()
    {
        Route::get('/', 'Api\v1\LanguageController@all');
        Route::get('/{id}', 'Api\v1\LanguageController@get');
    });

    Route::group(array('prefix' => 'customers'), function()
    {
        Route::get('/{id}', 'Api\v1\CustomerController@get');
        Route::post('/', 'Api\v1\CustomerController@add');
        Route::post('/login', 'Api\v1\CustomerController@login');

        Route::get('{customerId}/address/', 'Api\v1\CustomerController@getAddressCustomerId');
        Route::get('{customerId}/address/{id}', 'Api\v1\CustomerController@getAddressById');
        Route::post('{customerId}/address/', 'Api\v1\CustomerController@addAddress');

        Route::get('{customerId}/orders/', 'Api\v1\CustomerController@getOrders');
        Route::get('{customerId}/orders/{id}', 'Api\v1\CustomerController@getOrderById');
        Route::get('{customerId}/orders/{id}/status', 'Api\v1\CustomerController@getOrderStatusByOrderId');
        Route::post('{customerId}/orders/', 'Api\v1\CustomerController@addOrder');
    });

    Route::group(array('prefix' => 'photos'), function()
    {
        Route::post('/add', 'Api\v1\PhotoController@add');
    });

    Route::group(array('prefix' => 'orders_status'), function()
    {
        Route::get('/', 'Api\v1\OrdersStatusController@all');
        Route::get('/{id}', 'Api\v1\OrdersStatusController@get');
    });

});
