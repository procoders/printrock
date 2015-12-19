<?php

use App\Models;
use SleepingOwl\Admin\Models\Form\FormGroup;

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
        Column::callback('name', 'Name')
            ->contentCallback(function($instance) {
                $language = config('admin.default_language_code');
                $languageModel = Models\Language::where('code', $language)->first();

                if (empty($languageModel)) {
                    $languageModel = Models\Language::first();
                }

                return $instance->descriptions()->where('language_id', $languageModel->id)->first()->name;
            });
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
        FormItem::text('code', 'Code')
            ->group('general')
            ->validationRule('required');

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

        FormGroup::create('general', 'General')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
        FormGroup::create('descriptions', 'Status Descriptions')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
    })
    ->viewFilters(function()
    {
        ViewFilter::text('code', 'Code');
//        ViewFilter::text('name', 'Name');
    });