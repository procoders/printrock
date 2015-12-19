<?php
namespace App\AdminCustom\Forms;

use AssetManager;
use SleepingOwl\Html\HtmlBuilder;
use SleepingOwl\Admin\Models\Form\FormItem\Text;
use SleepingOwl\Admin\Models\Form\Interfaces\FormItemInterface;
use URL;
use App\Models as Models;
use SleepingOwl\Admin\Admin;
use SleepingOwl\Admin\Models\Form\FormItem\Traits\JsValidator;

/**
 * Class CustomTextField
 * @package App\AdminCustom\Forms
 */
class CustomTextField extends Text implements FormItemInterface
{
    use JsValidator;

    protected $label;
    protected $name;
    protected $callback;

    public function label($label)
    {
        $this->label = (string)$label;
        return $this;
    }

    public function name($name)
    {
        $this->name = (string)$name;
        return $this;
    }

    public function callback($function)
    {
        if (is_callable($function))
        {
            $this->callback = $function;
        }
        return $this;
    }

    public function render()
    {

        $value = Admin::$instance->formBuilder->getSessionStore()->getOldInput($this->name);

        if (is_null($value)) {
            $model = $this->form->instance;
            $callback = $this->callback;
            $value = $callback($model);
        }

        return HtmlBuilder::text($this->name, $this->label, $value, $this->getOptions($this->attributes));
    }
}