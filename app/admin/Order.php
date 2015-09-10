<?php

use App\Models;
use SleepingOwl\Admin\Models\Form\FormGroup;

Admin::model(\App\Models\Order::class)
    ->title('Orders')
    ->denyCreating(function ()
    {
        return true;
    })
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('customer.login', 'Customer')
            ->inlineEdit(true);
        Column::callback('orders_status_id', 'Status')
            ->contentCallback(function($instance) {
                return $instance->status()->first()->getName();
            })
            ->inlineEdit(true);
        Column::string('total', 'Total')
            ->inlineEdit(true);
        Column::count('items', 'Items');
    })
    ->inlineEdit(function($field) {
        switch($field) {
            case 'customer.login':
                return function() {
                    InlineEditItem::select('customer_id', NULL)
                        ->list(Models\Customer::class);
                };
                break;
            case 'orders_status_id':
                return function() {
                    InlineEditItem::select('orders_status_id', NULL)
                        ->list(Models\OrdersStatus::class);
                };
                break;
            case 'total':
                return function() {
                    InlineEditItem::text('total', NULL)
                        ->validationRule('required|regexp:\d');
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
            ->validationRule('required|numeric|exists:customers,id')
            ->group('general');
        FormItem::select('orders_status_id', 'Status')
            ->list(Models\OrdersStatus::class)
            ->validationRule('required|numeric|exists:orders_statuses,id')
            ->group('general');
        FormItem::text('total', 'Total')
            ->validationRule('required|numeric|min:1')
            ->group('general');
        FormItem::items('items', 'Items')
            ->group('items');

        FormGroup::create('general', 'General')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
        FormGroup::create('items', 'Items')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
    })
    ->viewFilters(function()
    {
        ViewFilter::text('customer.login', 'Customer');
        ViewFilter::dropdown('orders_status_id', 'Status')
            ->options(function () {
                $options = [
                    ['id' => '', 'name' => '- Status -']
                ];
                return array_merge($options, App\Models\Repositories\OrdersStatusRepository::getOptionsList());
            });
    });