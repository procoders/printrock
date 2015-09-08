<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;

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
            $image = $attributes['image'];
            $imageName = md5(time()) . '.' . $image->guessClientExtension();
            $imagePath = 'photos/' . $attributes['customer_id'];
            $image->move($imagePath, $imageName);

            $params['image'] = $imagePath . '/' . $imageName;
            $params['customer_id'] = $attributes['customer_id'];

            $this->model->fill($params);

            $this->model->save();
        }
    }

}