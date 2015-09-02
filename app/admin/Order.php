<?php

use App\Models;
use SleepingOwl\Admin\Models\Form\FormGroup;

Admin::model(\App\Models\Order::class)
    ->title('Orders')
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('customer.login', 'Customer');
        Column::string('status.code', 'Status');
        Column::string('total', 'Total')
            ->inlineEdit(true);
    })
    ->inlineEdit(function($field) {
        switch($field) {
            case 'code':
                return function() {
                    InlineEditItem::text('code', NULL)
                        ->validationRule('required');
                };
                break;
            case 'default':
                return function() {
                    InlineEditItem::checkbox('default', NULL);
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
            ->required()
            ->group('general');
        FormItem::select('orders_status_id', 'Status')
            ->list(Models\OrdersStatus::class)
            ->required()
            ->group('general');
        FormItem::text('total', 'Total')
            ->group('general');

        FormGroup::create('general', 'General')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
        FormGroup::create('items', 'Items')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
    })
    ->viewFilters(function()
    {
//        ViewFilter::text('code', 'Code');
    });