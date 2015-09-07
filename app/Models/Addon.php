<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class Addon
 * @package App\Models
 */
class Addon extends SleepingOwlModel {

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
    protected $fillable = ['name', 'addons_type_id', 'addon_id', 'image', 'price_type', 'price'];

    /**
     * Model guarded fields
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return mixed
     */
    public function type()
    {
        return $this->belongsTo(AddonsType::class, 'addons_type_id');
    }
}