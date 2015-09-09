<?php

use App\Models;
use SleepingOwl\Admin\Models\Form\FormGroup;

Admin::model(\App\Models\OrdersItem::class)
    ->title('Orders')
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::image('photo', 'Photo')
            ->modelMethod('photo');
        Column::string('order_id', 'Order');
        Column::string('qty', 'Qty');
        Column::string('price_per_item', 'Price per item');
    })
    ->inlineEdit(function($field) {
        switch($field) {
            case 'qty':
                return function() {
                    InlineEditItem::text('qty', NULL)
                        ->validationRule('required');
                };
                break;
            default:
                return function() {};
                break;
        }
    })
    ->form(function ()
    {
        FormItem::select('order_id', 'Order')
            ->list(Models\Order::class)
            ->required()
            ->group('general');
        FormItem::text('qty', 'Qty')
            ->group('general');
        FormItem::text('price_per_item', 'Price per item')
            ->group('general');

        FormGroup::create('general', 'General')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
        FormGroup::create('addons', 'Addons')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
    })
    ->viewFilters(function()
    {
//        ViewFilter::text('code', 'Code');
    });