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

    /**
     * This method will build options array
     *
     * @return array
     */
    public static function getOptionsList()
    {
        $options = [];

        foreach (Models\OrdersStatus::all() as $status) {
            $options[] = [
                'id' => $status->id,
                'name' => $status->getName()
            ];
        }

        return $options;
    }

    /**
     * Returns name
     *
     * @return mixed
     */
    public function getName()
    {
        $language = 'en';

        $languageId = Models\Language::where('code', $language)->first()->id;

        return $this->model->descriptions()->where('language_id', $languageId)->first()->name . ' (' . $this->model->code . ')';
    }

    public function getList()
    {
        $list = [];

        foreach (Models\OrdersStatus::all() as $status) {
            $list[$status->id] = $status->getName();
        }

        return $list;
    }
}