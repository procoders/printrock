<?php

Admin::model(\App\Models\Customer::class)
    ->title('Customers')
    ->denyEditingAndDeleting(function ($instance)
    {
        return false;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('name', 'Name')
            ->inlineEdit(true);
        Column::string('second_name', 'Second Name')
            ->inlineEdit(true);
        Column::string('last_name', 'Last Name')
            ->inlineEdit(true);
        Column::string('email', 'Email');
        Column::string('login', 'Login');
    })
    ->inlineEdit(function($field) {
        switch($field) {
            case 'name':
                return function() {
                    InlineEditItem::text('name', NULL)
                        ->validationRule('required|regex:/^[a-zA-Z0-9_@]{3,100}$/');
                };
                break;
            case 'second_name':
                return function() {
                    InlineEditItem::text('second_name', NULL)
                        ->validationRule('required|regex:/^[a-zA-Z0-9_@]{3,100}$/');
                };
                break;
            case 'last_name':
                return function() {
                    InlineEditItem::text('last_name', NULL)
                        ->validationRule('required|regex:/^[a-zA-Z0-9_@]{3,100}$/');
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
        FormItem::text('second_name', 'Second Name')->validationRule('required');
        FormItem::text('last_name', 'Last Name')->validationRule('required');
        FormItem::email('email', 'Email')->validationRule('required|email');
        FormItem::text('phone', 'Phone')->validationRule('required');
        FormItem::text('login', 'Login')->validationRule('required');
        FormItem::text('password', 'Password')->validationRule('required');

    })
    ->viewFilters(function()
    {
        ViewFilter::text('name', 'Name');
        ViewFilter::text('second_name', 'Second Name');
        ViewFilter::text('last_name', 'Last Name');
        ViewFilter::text('email', 'Email');
    });