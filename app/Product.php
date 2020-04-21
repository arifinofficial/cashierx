<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'main_product_id',
        'name',
        'sku',
        'picture',
        'variant',
        'qty',
        'price'
    ];

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
