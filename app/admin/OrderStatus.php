<?php

use SleepingOwl\Admin\Models\ModelItem;
use SleepingOwl\Admin\Models\Form\FormGroup;

Admin::model(\App\Models\OrdersStatus::class)
    ->title('Statuses')
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('code', 'Code')
            ->inlineEdit(true);
        Column::boolean('default', 'Default')
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
        FormItem::text('code', 'Code')->validationRule('required')
            ->group('status');
        FormItem::checkbox('default', 'Default')
            ->group('status');
        FormItem::descriptions()
            ->useTabs(true)
            ->type('model')
            ->modelMethod('descriptions')
            ->fields(
                [
                    'name' => [
                        'name' => 'Name',
                        'value' => 'name',
                        'type' => 'text',
                        'validation' => 'required'
                    ]
                ]
            )
            ->group('descriptions');

        FormGroup::create('status', 'Status')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
        FormGroup::create('descriptions', 'Status Descriptions')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
    })
    ->viewFilters(function()
    {
        ViewFilter::text('code', 'Code');
    });