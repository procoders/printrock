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
    protected $fillable = ['customer_id', 'orders_status_id', 'total', 'comment'];

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
        return $this->belongsTo(Customer::class);
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
        return $this->belongsTo(OrdersStatus::class, 'orders_status_id');
    }

    /**
     * This method will return order repository
     *
     * @return Repositories\Order
     */
    public function getRepository()
    {
        return new Repositories\OrderRepository($this);
    }

}