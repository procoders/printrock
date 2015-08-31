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
     * This method will set model values
     *
     * @param array $attributes
     */
    public function fill(array $attributes)
    {
        if (isset($attributes['password'])) {
            $attributes['password'] = \Hash::make($attributes['password']);
        }
        parent::fill($attributes);
    }

    /**
     * @return mixed
     */
    public function address()
    {
        return $this->hasMany(CustomerAddress::class);
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

}