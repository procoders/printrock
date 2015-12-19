<?php

namespace App\Models\Repositories;

use App\Models\Repositories\Interfaces as Interfaces;
use App\Models as Models;
use Input;

/**
 * Class AddonsTypeRepository
 *
 * @package App\Models\Photo
 */
Class AddonsTypeRepository implements Interfaces\iAdminSave
{
    use Traits\DescriptionTrait;

    protected $model = null;

    /**
     * @param \App\Models\AddonsType $model
     */
    public function __construct(Models\AddonsType $model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @param array $attributes
     */
    public function saveFromArray(array $attributes = array())
    {
        dd($attributes);
        $this->model->fill($attributes);
        $this->model->save();

        $languages = Models\Language::all();

        foreach ($languages as $language) {
            $descriptions[$language->id] = array(
                'name' => (isset($attributes['name'][$language->id])) ? $attributes['name'][$language->id] : '',
            );
        }

        $this->saveDescriptions($this->model, $descriptions, Models\AddonsTypesDescription::class);
    }

}