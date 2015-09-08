<?php

use App\Models;

Admin::model(\App\Models\Addon::class)
    ->title('Addons')
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('name', 'Name')
            ->inlineEdit(true);
        Column::string('type.name', 'Type');
        Column::string('price_type', 'Price Type');
        Column::string('price', 'Price');
    })
    ->inlineEdit(function($field) {
        switch($field) {
            case 'name':
                return function() {
                    InlineEditItem::text('name', NULL)
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
        FormItem::text('name', 'Name')->validationRule('required');
        FormItem::select('addons_type_id', 'Type')
            ->list(Models\AddonsType::class)
            ->required();
        FormItem::text('image', 'Image')->validationRule('required');
        FormItem::select('price_type', 'Price Type')
            ->list(['price' => 'price', 'percent' => 'percent'])
            ->required();
        FormItem::text('price', 'Price')->validationRule('required');
    })
    ->viewFilters(function()
    {
        ViewFilter::text('name', 'Name');
        ViewFilter::text('type.name', 'Type');
        ViewFilter::text('price_type', 'Price Type');
    });