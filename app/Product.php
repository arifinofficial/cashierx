<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'main_product_id',
        'name',
        'is_active',
        'picture',
        'variant',
        'qty',
        'price',
        'grab_price'
    ];

    protected $dates =['deleted_at'];

    /**
     * Has many relation to product_items
     *
     * @return collection
     */
    public function productItems()
    {
        return $this->hasMany(ProductItem::class);
    }

    /**
     * Reverse one to many to table main_products
     *
     * @return collection
     */
    public function mainProduct()
    {
        return $this->belongsTo(MainProduct::class);
    }

    /**
     * Reverse one to many to table units
     *
     * @return collection
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
