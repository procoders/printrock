<?php

use SleepingOwl\Admin\Models\ModelItem;

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
    })
    ->viewFilters(function()
    {
        ViewFilter::text('name', 'Name');
    });