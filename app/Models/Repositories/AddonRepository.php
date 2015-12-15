<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;
use Input;

/**
 * Class AddonRepository
 *
 * @package App\Models\Photo
 */
Class AddonRepository implements Interfaces\iAdminSave
{
    protected $model = null;

    /**
     * @param \App\Models\Addon $model
     */
    public function __construct(Models\Addon $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param array $attributes
     */
    public function saveFromArray(array $attributes = array())
    {
        $params = $attributes;
        if (isset($attributes['image'])) {
            if (is_object($attributes['image'])) {
                $imageName = '/addons/' . md5(time() . rand(0, 999)) . '.' . $attributes['image']->guessClientExtension();
                $imagePath = public_path() . DIRECTORY_SEPARATOR . 'addons' . DIRECTORY_SEPARATOR;
                $attributes['image']->move($imagePath, $imageName);
                $params['image'] = $imageName;
            }
        }

        $this->model->fill($params);
        $this->model->save();
    }

}