<?php
namespace App\Models;

use SleepingOwl\Models\SleepingOwlModel;

/**
 * Class Photo
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

    /**
     * This method will return photo repository
     *
     * @return Repositories\PhotoRepository
     */
    public function getRepository()
    {
        return new Repositories\PhotoRepository($this);
    }

    /**
     * Deletes photos
     *
     * @return mixed
     */
    public function delete()
    {
        $imageUrl = $this->image;

        if (unlink($imageUrl)) {
            return parent::delete();
        }
    }
}