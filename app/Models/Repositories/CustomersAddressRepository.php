<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;

/**
 * Class CustomersAddressRepository
 *
 * @package App\Models\Repositories
 */
Class CustomersAddressRepository implements Interfaces\iAdminSave
{
    protected $model = null;

    /**
     * @param \App\Models\CustomersAddress $model
     */
    public function __construct(Models\CustomersAddress $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param array $attributes
     */
    public function saveFromArray(array $attributes = array())
    {
        $this->model->save();
    }

}