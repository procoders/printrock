<?php
namespace App\AdminCustom\Forms;

use AssetManager;
use SleepingOwl\Admin\Models\Form\FormItem\Image;
use SleepingOwl\Admin\Models\Form\Interfaces\FormItemInterface;
use URL;
use SleepingOwl\Admin\Admin;

class ImageField extends Image implements FormItemInterface
{

    protected $_column;
    protected $label = '';

    public function column($column)
    {
        $column = trim($column);

        if (empty($column))
            throw new \Exception('Column value can\'t be empty');

        $this->_column = $column;

        return $this;
    }

    public function render()
    {
        AssetManager::addScript('/js/admin/fileinput.min.js');
        AssetManager::addStyle('/css/admin/fileinput.min.css');

        $column = $this->_column;
        $img = $this->form->instance->$column;

        return view('admin/form/custom_image')
            ->with('imagePath', $img)
            ->with('label', $this->label);
    }

    public function label($label)
    {
        $this->label = $label;
    }

}