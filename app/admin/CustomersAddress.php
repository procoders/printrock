<?php

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
        Column::string('country', 'Country')
            ->inlineEdit(true);
        Column::string('city', 'City')
            ->inlineEdit(true);
        Column::string('zip_code', 'Zip Code')
            ->inlineEdit(true);

    })
    ->inlineEdit(function($field) {
        switch($field) {
            case 'country':
                return function() {
                    InlineEditItem::text('country', NULL)
                        ->validationRule('required|alpha');
                };
                break;
            case 'city':
                return function() {
                    InlineEditItem::text('city', NULL)
                        ->validationRule('required|alpha');
                };
                break;
            case 'zip_code':
                return function() {
                    InlineEditItem::text('zip_code', NULL)
                        ->validationRule('required|regex:^\d{5}(?:[-\s]\d{4})?$');
                };
                break;
            default:
                return function() {};
                break;
        }
    })
    ->form(function ()
    {
        FormItem::select('customer_id', 'Customer')
            ->list(Models\Customer::class)
            ->validationRule('required|numeric|exists:customers,id');
        FormItem::text('country', 'Country')->validationRule('required|alpha');
        FormItem::text('city', 'City')->validationRule('required|alpha');
        FormItem::text('phone', 'Phone')->validationRule('required');
        FormItem::text('zip_code', 'Zip Code')->validationRule('required');

    })
    ->viewFilters(function()
    {
        ViewFilter::text('customer.name', 'Customer');
        ViewFilter::text('country', 'Country');
        ViewFilter::text('city', 'City');
        ViewFilter::text('zip_code', 'Zip Code');
    });