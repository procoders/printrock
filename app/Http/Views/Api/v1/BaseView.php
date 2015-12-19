<?php

namespace App\Http\Views\Api\v1;

use App\Models as Models;

abstract class BaseView
{
    /**
     * @var
     */
    protected $_model;

    /**
     * @param $model
     */
    public function __construct($model)
    {
        $this->_model = $model;
    }

    abstract public function get();

    protected function _getDefaultLanguageId()
    {
        $langModel = Models\Language::where('default', true)->first();

        if (is_null($langModel))
            $langModel = Models\Language::first();

        return $langModel->id;
    }
}