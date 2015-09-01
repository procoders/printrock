<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class Administrator
 * @package App\Models
 */
class Order extends SleepingOwlModel {

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
    protected $fillable = ['customer_id', 'order_status_id', 'total'];

    /**
     * Model guarded fields
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return mixed
     */
    public function customer()
    {
        return $this->belongsTo(Custmer::class);
    }

    /**
     * @return mixed
     */
    public function items()
    {
        return $this->hasMany(OrdersItem::class);
    }

    /**
     * @return mixed
     */
    public function status()
    {
        return $this->hasOne(OrdersStatus::class);
    }
}