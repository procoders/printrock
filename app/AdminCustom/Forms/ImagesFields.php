<?php
namespace App\AdminCustom\Forms;

use AssetManager;
use SleepingOwl\Admin\Models\Form\FormItem\Image;
use SleepingOwl\Admin\Models\Form\Interfaces\FormItemInterface;
use URL;
use SleepingOwl\Admin\Admin;

class ImagesFields extends Image implements FormItemInterface
{
    protected $modelMethod;
    protected $fields;
    protected $type;

    public function modelMethod($method) {
        $this->modelMethod = $method;

        return $this;
    }

    public function fields($fields) {
        if (!is_array($fields))
            return false;
        $this->fields = $fields;
        return $this;
    }

    public function render()
    {
        $model = $this->form->instance;

        if (empty($model)) {
            return false;
        }

        $method = $this->modelMethod;

        $editImages = Admin::$instance->formBuilder->getSessionStore()->getOldInput('edit_images');

        $images = [];
        if ($editImages) {
            foreach ($model->$method()->get() as $image) {
                if (in_array($image->id, $editImages)) {
                    $images[] = $image;
                }
            }
        } else {
            $images = $model->$method()->get();
        }

        AssetManager::addScript('/js/admin/fileinput.min.js');
        AssetManager::addStyle('/css/admin/fileinput.min.css');
        return view('admin/form/images')->with('images', $images);
    }

    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    public function label($label)
    {
        $this->label = $label;
        return $this;
    }
}