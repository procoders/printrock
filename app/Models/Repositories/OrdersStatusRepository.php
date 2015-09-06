<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;

/**
 * Class OrdersStatusRepository
 *
 * @package App\Models\Repositories
 */
Class OrdersStatusRepository implements Interfaces\iAdminSave
{
    use Traits\DescriptionTrait;

    protected $model = null;

    /**
     * @param \App\Models\OrdersStatus $model
     */
    public function __construct(Models\OrdersStatus $model)
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

        $languages = Models\Language::all();

        foreach ($languages as $language) {
            $descriptions[$language->id] = array(
                'name' => (isset($attributes['name'][$language->id])) ? $attributes['name'][$language->id] : '',
            );
        }

        $this->saveDescriptions($this->model, $descriptions, Models\OrdersStatusesDescription::class);
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