<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class Administrator
 * @package App\Models
 */
class Customer extends SleepingOwlModel {

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
    protected $fillable = ['name', 'second_name', 'last_name', 'email', 'phone', 'login', 'password'];

    /**
     * Model guarded fields
     *
     * @var array
     */
    protected $guarded = array('id');

    /**
     * @return mixed
     */
    public function addresses()
    {
        return $this->hasMany(CustomersAddress::class);
    }

    /**
     * @return mixed
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @return mixed
     */
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    /**
     * @return mixed
     */
    public static function getList()
    {
        return static::lists('login', 'id')->all();
    }

    /**
     * This method will return customer repository
     *
     * @return Repositories\CustomerRepository
     */
    public function getRepository()
    {
        return new Repositories\CustomerRepository($this);
    }

}