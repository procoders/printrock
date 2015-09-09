<?php

use SleepingOwl\Admin\Models\Form\FormGroup;

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
        Column::count('photos', 'Photos');
        Column::count('addresses', 'Addresses');
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
        FormItem::text('name', 'Name')->validationRule('required')->group('general');
        FormItem::text('second_name', 'Second Name')->validationRule('required')->group('general');
        FormItem::text('last_name', 'Last Name')->validationRule('required')->group('general');
        FormItem::email('email', 'Email')->validationRule('required|email')->group('general');
        FormItem::text('phone', 'Phone')->validationRule('required')->group('general');

        if (! preg_match('/edit$/', Request::url()) && ! preg_match('/update$/', Request::url())) {
            FormItem::text('login', 'Login')->validationRule('required')->group('general');
            FormItem::text('password', 'Password')->validationRule('required')->group('general');
        }

        FormItem::images()
            ->type('model')
            ->modelMethod('photos')
            ->group('photos');

        FormGroup::create('general', 'General')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);
        FormGroup::create('photos', 'Photos')->setDisplayType(FormGroup::DISPLAY_TYPE_FULL);

    })
    ->viewFilters(function()
    {
        ViewFilter::text('name', 'Name');
        ViewFilter::text('second_name', 'Second Name');
        ViewFilter::text('last_name', 'Last Name');
        ViewFilter::text('email', 'Email');
    });