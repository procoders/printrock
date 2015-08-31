<?php

use SleepingOwl\Admin\Models\ModelItem;

Admin::model(\App\Models\Administrator::class)
    ->title('Administrators')
    ->denyDeleting(function ($instance)
    {
        return true;
    })
    ->columns(function ()
    {
        Column::string('id', 'Id');
        Column::string('username', 'Login');
        Column::string('name', 'Name')
            ->inlineEdit(true);
        Column::string('email', 'Email');
    })
    ->inlineEdit(function($field) {
        switch($field) {
            case 'name':
                return function() {
                    InlineEditItem::text('name', NULL)
                        ->validationRule('required|regex:/^[a-zA-Z0-9_@]{3,20}$/');
                };
                break;
            default:
                return function() {};
                break;
        }
    })
    ->form(function ()
    {
        // Describing elements in create and editing forms
        FormItem::text('username', 'Login')->validationRule('required|regex:/^[a-zA-Z0-9_@]{3,20}$/');
        FormItem::text('name', 'Name')->validationRule('required|regex:/^[a-zA-Z0-9_\s@]{3,20}$/');
        FormItem::email('email', 'Email')->validationRule('required|email');


        $data = Input::all();

        if (preg_match('/edit$/', Request::url()) || (isset($data['_method']) && $data['_method'] == 'PUT')) {
            // ok this is update statement, so let's rock
            FormItem::checkbox('changePassword', 'Change Password');

            if (isset($data['changePassword']) && $data['changePassword'] == 1) {
                FormItem::text('passwd', 'Password')->validationRule('required|regex:/^[a-zA-Z0-9_@]{6,20}$/');
                FormItem::text('passwdConfirm', 'Password Confirmation')->validationRule('required|same:passwd');
            } else {
                FormItem::password('passwd', 'Password');
                FormItem::password('passwdConfirm', 'Password Confirmation');
            }
        } else {
            // this is create statement
            FormItem::password('passwd', 'Password')->validationRule('required|regex:/^[a-zA-Z0-9_@]{6,20}$/');
            FormItem::password('passwdConfirm', 'Password Confirmation')->validationRule('required|same:passwd');
        }
    });