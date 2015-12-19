<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class Administrator
 * @package App\Models
 */
class OrdersItem extends SleepingOwlModel {

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
    protected $fillable = ['order_id', 'photo_id', 'qty', 'format_price', 'format_id'];

    /**
     * Model guarded fields
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return mixed
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * @return mixed
     */
    public function photo()
    {
        return $this->belongsTo(Photo::class);
    }

    /**
     * @return mixed
     */
    public function format()
    {
        return $this->belongsTo(Format::class);
    }

    /**
     * @return mixed
     */
    public function ordersItemsAddons()
    {
        return $this->hasMany(OrdersItemsAddon::class);
    }
}