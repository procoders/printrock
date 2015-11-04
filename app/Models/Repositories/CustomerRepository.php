<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;

/**
 * Class CustomerRepository
 *
 * @package App\Models\Repositories
 */
Class CustomerRepository implements Interfaces\iAdminSave
{
    protected $model = null;

    /**
     * @param \App\Models\Customer $model
     */
    public function __construct(Models\Customer $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param array $attributes
     */
    public function saveFromArray(array $attributes = array())
    {
        $this->model->fill($attributes);

        $this->model->save();

        $attributes['customer_id'] = $this->model->id;

        if (isset($attributes['images'])) {
            foreach ($attributes['images'] as $image) {
                $photoModel = new Models\Photo();

                $params = [
                    'customer_id' => $this->model->id,
                    'image' => $image
                ];

                $photoModel->getRepository()->saveFromArray($params);
            }
        }
    }

}