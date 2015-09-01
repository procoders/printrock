<?php

namespace App\Models\Repositories\Traits;

trait DescriptionTrait
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $model Model which would be processed
     * @param array $descriptions Array with descriptions [$languageId => [$fieldName => $fieldValue]]
     * @param string $descriptionModel Description model name
     * @param string $method Model method, to get and save yours descriptions
     * @return bool
     */
    public function saveDescriptions(\Illuminate\Database\Eloquent\Model $model, $descriptions, $descriptionModel, $method = 'descriptions')
    {
        $existingDescriptions = $model->$method()->get();

        foreach ($existingDescriptions as $description) {
            $languageId = $description->language_id;
            if (! isset($descriptions[$languageId])) {
                $description->delete();
            } else {
                $existingDescriptions[$languageId] = $description;
            }
        }

        foreach ($descriptions as $languageId => $description) {
            if (isset($existingDescriptions[$languageId])) {
                foreach ($description as $key => $value) {
                    $existingDescriptions[$languageId]->$key = $value;
                }
                $existingDescriptions[$languageId]->update();
            } else {
                $descriptionModel = new $descriptionModel;
                $descriptionModel->language_id = $languageId;
                foreach ($description as $key => $value) {
                    $descriptionModel->$key = $value;
                }
                $model->$method()->save($descriptionModel);
            }
        }

    }

}