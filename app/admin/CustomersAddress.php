<?php

use SleepingOwl\Admin\Models\ModelItem;
use App\Models;

Admin::model(\App\Models\CustomersAddress::class)
    ->title('Customers Addresses')
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('customer.name', 'Customer');
        Column::string('country', 'Country');
        Column::string('city', 'City');
        Column::string('zip_code', 'Zip Code');

    })
    ->form(function ()
    {
        FormItem::select('customer_id', 'Customer')
            ->list(Models\Customer::class)
            ->required();
        FormItem::text('country', 'Country')->validationRule('required');
        FormItem::text('city', 'City')->validationRule('required');
        FormItem::text('phone', 'Phone')->validationRule('required');
        FormItem::text('zip_code', 'Zip Code')->validationRule('required');

    })
    ->viewFilters(function()
    {

    });