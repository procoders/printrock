<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class AddonsType
 * @package App\Models
 */
class AddonsType extends SleepingOwlModel {

    /**
     * Primary column
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Models fillable fields
     *
     * @var array
     */
    protected $fillable = ['code'];

    /**
     * Model guarded fields
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return mixed
     */
    public static function getList()
    {
        $values = [];

        $language = config('admin.default_language_code');
        $languageModel = Language::where('code', $language)->first();

        if (empty($languageModel)) {
            $languageModel = Language::first();
        }

        foreach (AddonsType::all() as $type) {
            $description = $type->descriptions()->where('language_id', $languageModel->id)->first();
            $values[$type->id] = (!is_null($description)) ? $description->name : '[' . $type->id . ']';
        }

        return $values;
    }

    public function descriptions()
    {
        return $this->hasMany(AddonsTypesDescription::class);
    }

    public function getRepository()
    {
        return new Repositories\AddonsTypeRepository($this);
    }
}