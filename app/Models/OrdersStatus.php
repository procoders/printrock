<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;
use App\Models;

/**
 * Class OrdersStatus
 * @package App\Models
 */
class OrdersStatus extends SleepingOwlModel {

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
    protected $fillable = ['code', 'default'];

    /**
     * Model guarded fields
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return mixed
     */
    public function descriptions()
    {
        return $this->hasMany(OrdersStatusesDescription::class);
    }

    /**
     * @return mixed
     */
    public function languages()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    /**
     * @return mixed
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * This method will return orders status repository
     *
     * @return Repositories\OrdersStatusRepository
     */
    public function getRepository()
    {
        return new Repositories\OrdersStatusRepository($this);
    }

    /**
     * @return mixed
     */
    public static function getList()
    {
        $model = new Models\OrdersStatus();

        return $model->getRepository()->getList();
    }

    /**
     * Returns name
     */
    public function getName()
    {
        return $this->getRepository()->getName();
    }

}