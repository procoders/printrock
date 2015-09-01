<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class Administrator
 * @package App\Models
 */
class Photo extends SleepingOwlModel {

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
    protected $fillable = ['customer_id', 'image'];

    /**
     * Model guarded fields
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return mixed
     */
    public function orderItem()
    {
        return $this->belongsTo(OrdersItem::class);
    }
}