<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class AddonsTypesDescription
 * @package App\Models
 */
class AddonsTypesDescription extends SleepingOwlModel {

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
    protected $fillable = ['language_id', 'name', 'addons_type_id'];

    /**
     * Model guarded fields
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return mixed
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * @return mixed
     */
    public function addonsType()
    {
        return $this->belongsTo(AddonsType::class);
    }

}