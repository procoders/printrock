<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;
//use App\AdminCustom\Helpers\Admin;

/**
 * Class BookingRepository
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

    public function isSuperAdmin()
    {
        return (is_null($this->model->hotel_id)) ? true : false;
    }

    public static function getOptionsList($dependsOn = 'hotel_id')
    {
        $options = ['-1' => 'All administrators'];
//        if (!Admin::getInstance()->isSuperAdmin()) {
//            $dependsOnValue = Admin::getInstance()->getHotelId();
//        } else {
//            $dependsOnValue = \Input::get($dependsOn);
//        }
//        if (isset($dependsOnValue) && $dependsOnValue != '-1') {
//            foreach(Models\Administrator::where($dependsOn, '=', $dependsOnValue)->get() as $admin) {
//                $options[$admin->id] = $admin->name;
//            }
//        } else {
//            foreach(Models\Administrator::all() as $admin) {
//                $options[$admin->id] = $admin->name;
//            }
//        }
        return $options;
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