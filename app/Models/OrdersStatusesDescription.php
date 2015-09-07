<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class OrdersStatusesDescription
 * @package App\Models
 */
class OrdersStatusesDescription extends SleepingOwlModel {

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
    protected $fillable = ['language_id', 'name', 'orders_status_id'];

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
    public function orderStatus()
    {
        return $this->belongsTo(OrdersStatus::class);
    }

}