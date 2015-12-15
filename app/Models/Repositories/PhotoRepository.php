<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;
use Input;

/**
 * Class PhotoRepository
 *
 * @package App\Models\Photo
 */
Class PhotoRepository implements Interfaces\iAdminSave
{
    protected $model = null;

    /**
     * @param \App\Models\Photo $model
     */
    public function __construct(Models\Photo $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param array $attributes
     */
    public function saveFromArray(array $attributes = array())
    {
        if ($attributes['image']) {
            $imageName = 'photos/' . md5(time() . rand(0, 999)) . '_' . $attributes['customer_id'] . '.' . $attributes['image']->guessClientExtension();
            $imagePath = public_path() . DIRECTORY_SEPARATOR . 'photos' . DIRECTORY_SEPARATOR;

            $attributes['image']->move($imagePath, $imageName);

            $params['image'] = $imageName;
            $params['customer_id'] = $attributes['customer_id'];

            $this->model->fill($params);

            $this->model->save();
        }
    }

}