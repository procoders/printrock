<?php

use App\Models;
use SleepingOwl\Admin\Models\Form\FormGroup;

Admin::model(\App\Models\Addon::class)
    ->title('Addons')
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::callback('name', 'Name')
            ->contentCallback(function($instance) {
                $language = config('admin.default_language_code');
                $languageModel = Models\Language::where('code', $language)->first();

                if (empty($languageModel)) {
                    $languageModel = Models\Language::first();
                }

                return $instance->descriptions()->where('language_id', $languageModel->id)->first()->name;
            });
        Column::callback('type', 'Type')
            ->contentCallback(function($instance) {
                $language = config('admin.default_language_code');
                $languageModel = Models\Language::where('code', $language)->first();

                if (empty($languageModel)) {
                    $languageModel = Models\Language::first();
                }
                return $instance->type()
                    ->first()
                    ->descriptions()
                    ->where('language_id', $languageModel->id)
                    ->first()
                    ->name;
            });
        Column::string('price_type', 'Price Type');
        Column::string('price', 'Price');
    })
    ->inlineEdit(function($field) {
        switch($field) {
            default:
                return function() {};
                break;
        }
    })
    ->form(function ()
    {

        FormItem::select('addons_type_id', 'Type')
            ->list(Models\AddonsType::class)
            ->validationRule('required');
        FormItem::select('price_type', 'Price Type')
            ->list(['price' => 'price', 'percent' => 'percent'])
            ->validationRule('required');
        FormItem::text('price', 'Price')->validationRule('required');
        FormItem::image()
            ->column('image')
            ->label('Image');

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
            );
    })
    ->viewFilters(function()
    {
        ViewFilter::text('name', 'Name');
        ViewFilter::text('type', 'Type');
        ViewFilter::text('price_type', 'Price Type');
    });