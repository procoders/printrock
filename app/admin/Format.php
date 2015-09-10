<?php

Admin::model(\App\Models\Format::class)
    ->title('Formats')
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('width', 'Width')
            ->inlineEdit(true);
        Column::string('height', 'Height')
            ->inlineEdit(true);
        Column::string('price', 'Price')
            ->inlineEdit(true);

    })
    ->inlineEdit(function($field) {
        switch($field) {
            case 'width':
                return function() {
                    InlineEditItem::text('width', NULL)
                        ->validationRule('required|regex:\d');
                };
                break;
            case 'height':
                return function() {
                    InlineEditItem::text('height', NULL)
                        ->validationRule('required|regex:\d');
                };
                break;
            case 'price':
                return function() {
                    InlineEditItem::text('price', NULL)
                        ->validationRule('required|regex:\d');
                };
                break;
            default:
                return function() {};
                break;
        }
    })
    ->form(function ()
    {
        FormItem::text('width', 'Width')->validationRule('required|numeric');
        FormItem::text('height', 'Height')->validationRule('required|numeric');
        FormItem::text('price', 'Price')->validationRule('required|numeric');
    });