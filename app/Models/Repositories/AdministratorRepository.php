<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;

/**
 * Class AdministratorRepository
 *
 * @package App\Models\Repositories
 */
Class AdministratorRepository
{

    /**
     * @var Models\Administrator
     */
    protected $model;

    /**
     * @param Models\Administrator $model
     */
    public function __construct(Models\Administrator $model)
    {
        $this->model = $model;
        return $this;
    }

    public function inlineSave(array $data = [])
    {
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'name':
                case 'last_name':
                    $this->model->$key = trim($value);
                    $this->model->save();
                    break;
            }
        }
        return true;
    }
}