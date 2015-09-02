<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;
use Illuminate\Support\Facades\DB;

/**
 * Class HotelRepository
 *
 * @package App\Models\Repositories
 */
Class OrderRepository implements Interfaces\iAdminSave
{
    protected $model = null;

    /**
     * @param \App\Models\Order $model
     */
    public function __construct(Models\Order $model)
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

//    public function inlineSave(array $data = [])
//    {
//        foreach ($data as $key => $value) {
//            switch ($key) {
//                case 'name':
//                    $this->model->name = trim($value);
//                    $this->model->update();
//                    break;
//                case 'active':
//                    $this->model->default = (int)$value;
//                    $this->model->update();
//                    break;
//            }
//        }
//        return true;
//    }
}