<?php
namespace App\AdminCustom\Column;

use SleepingOwl\Admin\Columns\Column\BaseColumn;
use SleepingOwl\Admin\Admin;

class ImageColumn extends BaseColumn {

    protected $name;
    protected $label;
    protected $modelMethod;

    function __construct($name, $label = null)
    {
        $this->name = $name;

        if (is_null($label)) {
            $this->label = ucwords(str_replace('_', ' ', $name));
        } else {
            $this->label = $label;
        }

        $this->sortable(false);
        $this->htmlBuilder = Admin::instance()->htmlBuilder;
    }

    public function modelMethod($method)
    {
        $this->modelMethod = $method;

        return $this;
    }

    public function render($instance, $totalCount)
    {
        $method = $this->modelMethod;

        $image = $instance->$method()->first();

        return (string)view('admin/column/image')->with('src', $image->image);

    }

    public function getLabel()
    {
        return $this->label;
    }

}