<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class OrdersItemsAddon
 * @package App\Models
 */
class OrdersItemsAddon extends SleepingOwlModel {

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
    protected $fillable = ['orders_item_id', 'addon_id', 'qty', 'price_per_item'];

    /**
     * Model guarded fields
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return mixed
     */
    public function orderItems()
    {
        return $this->belongsTo(OrdersItem::class);
    }

    /**
     * @return mixed
     */
    public function addon()
    {
        return $this->belongsTo(Addon::class);
    }
}