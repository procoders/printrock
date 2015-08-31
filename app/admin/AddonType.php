<?php

use SleepingOwl\Admin\Models\ModelItem;

Admin::model(\App\Models\AddonsType::class)
    ->title('Addons Types')
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('code', 'Code')
            ->inlineEdit(true);
        Column::string('name', 'Name')
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
        FormItem::text('code', 'Code')->validationRule('required');
        FormItem::text('name', 'Name')->validationRule('required');
    })
    ->viewFilters(function()
    {
        ViewFilter::text('code', 'Code');
        ViewFilter::text('name', 'Name');
    });