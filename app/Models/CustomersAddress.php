<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class CustomersAddress
 * @package App\Models
 */
class CustomersAddress extends SleepingOwlModel {

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
    protected $fillable = [
        'customer_id',
        'country',
        'city',
        'phone',
        'zip_code',
        'street',
        'name'
    ];

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
     * This method will return customers address repository
     *
     * @return Repositories\CustomersAddressRepository
     */
    public function getRepository()
    {
        return new Repositories\CustomersAddressRepository($this);
    }
}