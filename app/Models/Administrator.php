<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;
//use App\AdminCustom\Helpers as AdminHelpers;

/**
 * Class Administrator
 * @package App\Models
 */
class Administrator extends SleepingOwlModel {

    const LOGIN_VALIDATION_REGEXP = '/^[a-zA-Z0-9_@]{3,20}$/';
    const NAME_VALIDATION_REGEXP = '/^[a-zA-Z0-9_\s@]{3,20}$/';

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
    protected $fillable = ['username', 'password', 'name', 'last_name', 'email'];

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
        parent::fill($attributes);

//        if (!empty($attributes)) {
//            $adminHelper = AdminHelpers\Admin::getInstance();
//            // admin section
//            if ($adminHelper->isLoggedOn()) {
//                if ($adminHelper->isSuperAdmin()) {
//                    // ok this is super admin, and he can create or change admin hotel subscription
//                    if (empty($this->hotel_id))
//                        $this->hotel_id = NULL;
//                } else {
//                    $this->hotel_id = $adminHelper->getHotelId();
//                }
//                if ($this->id == NULL) {
//                    // ok this is new member, so we need password for it
//                    $this->password = \Hash::make($attributes['passwd']);
//                } else {
//                    // updating admin
//                    if (!empty($attributes['changePassword']) && $attributes['changePassword'] == 1)
//                        $this->password = \Hash::make($attributes['passwd']);
//                }
//            }
//        }

    }

    /**
     * This method will return administrator repository
     *
     * @return Repositories\AdministratorRepository
     */
    public function getRepository()
    {
        return new Repositories\AdministratorRepository($this);
    }

    /**
     * @param $query
     * @param $name
     */
    public function scopeSearchByName($query, $name)
    {
        $query->where('name', 'like', "%$name%")->get();
    }

}