<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;
use Input;

/**
 * Class LanguageRepository
 *
 */
Class LanguageRepository implements Interfaces\iAdminSave
{
    protected $model = null;

    /**
     * @param \App\Models\Language $model
     */
    public function __construct(Models\Language $model)
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

        if ($this->model->id > 0 && $this->model->defaut == true) {
            $update = Models\Language::where('default', true)
                ->where('id', '!=', $this->model->id);
            $update->default = null;
            $update->save();
        }
        $this->model->save();
    }

}