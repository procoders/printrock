<?php

use SleepingOwl\Admin\Models\Form\FormGroup;
use App\Models;
use SleepingOwl\Html\HtmlBuilder;

Admin::model(\App\Models\OrdersStatus::class)
    ->title('Statuses')
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('code', 'Code')
            ->inlineEdit(true);
        Column::callback('name', 'Name')
            ->contentCallback(function($instance) {
                return $instance->getName();
            })
            ->inlineEdit(true);
        Column::boolean('default', 'Default');
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
                    InlineEditItem::callback('name', '')
                        ->callback(function($instance) {
                            $content = '';
                            foreach (Models\Language::get() as $language) {
                                $value = '';
                                $descriptions = $instance->descriptions->where('language_id', $language->id)->first();
                                if (!is_null($descriptions)) {
                                    $value = $descriptions->name;
                                }

                                $content .= HtmlBuilder::text('name_' . $language->id, 'Name [' . $language->code . ']', $value, ['data-parsley-required' => true]);
                            }

                            return $content;
                        });
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
    });