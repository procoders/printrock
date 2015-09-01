<?php
namespace App\AdminCustom\Forms;

use AssetManager;
use SleepingOwl\Admin\Models\Form\FormItem\Text;
use SleepingOwl\Admin\Models\Form\FormItem\Textarea;
use SleepingOwl\Admin\Models\Form\Interfaces\FormItemInterface;
use SleepingOwl\Html\HtmlBuilder;
use URL;
use App\Models as Models;
use SleepingOwl\Admin\Admin;
use SleepingOwl\Admin\Models\Form\FormItem\Traits\JsValidator;

/**
 * Class LanguagesFields
 * @package App\AdminCustom\Forms
 */
class LanguagesFields extends Text implements FormItemInterface
{
    use JsValidator;

    /**
     * @var string This is method name, to get descriptions from yours model
     */
    protected $modelMethod;

    /**
     * @var array This array contain fields which would be process
     */
    protected $fields;

    protected $type;

    protected $title;

    protected $supportedLanguages = [];

    /**
     * @var bool This setting allows you to sepparate output with tabs
     */
    protected $useTabs = false;

    /**
     * @param $val
     * @return $this
     */
    public function useTabs($val)
    {
        $this->useTabs = (bool)$val;
        return $this;
    }

    public function supportedLanguages($languages = [])
    {
        $this->supportedLanguages = $languages;
        return $this;
    }

    /**
     * @param $method
     * @return $this
     */
    public function modelMethod($method) {
        $this->modelMethod = $method;
        return $this;
    }

    /**
     * @param $fields
     * @return $this|bool
     */
    public function fields($fields) {
        if (!is_array($fields))
            return false;
        $this->fields = $fields;
        return $this;
    }

    /**
     * @return mixed
     */
    private function _getAvailableLanguages()
    {
        return (! empty($this->supportedLanguages)) ? $this->supportedLanguages : Models\Language::all();
    }

    /**
     * This method will load descriptions data or create new empty data if descriptions doesn't exists
     *
     * @return array
     */
    private function _getLanguageData()
    {
        // load descriptions
        $method = $this->modelMethod;
        $descriptionCollection = $this->form->instance->$method()->get();

        $languages = $this->_getAvailableLanguages();

        // fill fields collection
        $languageData = array();
        foreach($languages as $language) {
            $languageData[$language->id] = array();
            foreach ($this->fields as $fieldCode => $field) {
                $oldInput = Admin::$instance->formBuilder->getSessionStore()->getOldInput($fieldCode);
                if (!is_null($oldInput) && isset($oldInput[$language->id])) {
                    $languageData[$language->id][$fieldCode] = $oldInput[$language->id];
                } else {
                    $languageData[$language->id][$fieldCode] = '';
                }
            }
        }
        if (!empty($descriptionCollection)) {
            foreach ($descriptionCollection as $description) {
                foreach ($this->fields as $fieldCode => $field) {
                    $languageData[$description->language_id][$fieldCode] = $description->$fieldCode;
                }
            }
        }

        return $languageData;
    }

    /**
     * @return string
     */
    public function render()
    {
        $model = $this->form->instance;

        if (empty($model))
            return false;

        $fields = array();

        foreach ($this->_getLanguageData() as $languageId => $data) {
            $language = Models\Language::find($languageId);
            foreach ($data as $fieldCode => $fieldData) {
                $name = $this->fields[$fieldCode]['name'];
                $fieldTitle = ($this->useTabs) ? $name : $name . ' [' . $language->name . ']';
                $validationRules = isset($this->fields[$fieldCode]['validation']) ? explode('|', $this->fields[$fieldCode]['validation']) : [];
                switch ($this->fields[$fieldCode]['type']) {
                    case 'ckeditor':
                        $options =                             [
                            'id' => lcfirst($fieldCode) . '[' . $languageId . ']',
                            'data-editor' => Textarea::EDITOR_WYSIHTML
                        ];
                        $fields[$languageId][] = HtmlBuilder::textarea(
                            lcfirst($fieldCode) . '[' . $languageId . ']',
                            $fieldTitle,
                            $fieldData,
                            $this->getOptions($options, $validationRules)
                        );
                        break;
                    case 'textarea':
                        $options =                             [
                            'id' => lcfirst($fieldCode) . '[' . $languageId . ']'
                        ];
                        $fields[$languageId][] = HtmlBuilder::textarea(
                            lcfirst($fieldCode) . '[' . $languageId . ']',
                            $fieldTitle,
                            $fieldData,
                            $this->getOptions($options, $validationRules)
                        );
                        break;
                    case 'checkbox':
                        $hotelLanguage = $model->getRepository()->getHotelLanguage($languageId);
                        $options = array('id' => lcfirst($fieldCode) . '[' . $languageId . ']');

                        $oldCheckbox = Admin::$instance->formBuilder->getSessionStore()->getOldInput(lcfirst($fieldCode));

                        if (is_null($oldCheckbox)) {
                            if ($hotelLanguage && $hotelLanguage->active) {
                                $options = array_merge($options, array('checked' => 'checked'));
                            }
                        } else {
                            if ($oldCheckbox[$languageId] == 1) {
                                $options = array_merge($options, array('checked' => 'checked'));
                            }
                            $allOldInputs = Admin::$instance->formBuilder->getSessionStore()->get('_old_input');
                            $fieldName = lcfirst($fieldCode);
                            if (isset($allOldInputs[$fieldName])) {
                                if (isset($allOldInputs[$fieldName][$languageId])) {
                                    unset($allOldInputs[$fieldName][$languageId]);
                                }
                            }
                            Admin::$instance->formBuilder->getSessionStore()->set('_old_input', $allOldInputs);
                        }

                        $fields[$languageId][] = HtmlBuilder::checkbox(
                            lcfirst($fieldCode) . '[' . $languageId . ']',
                            $fieldTitle,
                            $fieldData,
                            $this->getOptions($options, $validationRules)
                        );
                        break;
                    default:
                        $options = ['id' => lcfirst($fieldCode) . '[' . $language->name . ']'];
                        $fields[$languageId][] = HtmlBuilder::text(
                            lcfirst($fieldCode) . '[' . $languageId . ']',
                            $fieldTitle,
                            $fieldData,
                            $this->getOptions($options, $validationRules)
                        );
                        break;
                }
            }
        }

        return view('admin/form/languages_fields')
            ->with('code', $this->modelMethod)
            ->with('withTabs', $this->useTabs)
            ->with('languages', $this->_getAvailableLanguages())
            ->with('fields', $fields)
            ->with('blockId', uniqid())
            ->with('title', $this->label);
    }

    /**
     * @param $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $label
     * @return $this
     */
    public function label($label)
    {
        $this->label = $label;
        return $this;
    }

}