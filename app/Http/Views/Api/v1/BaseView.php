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
}