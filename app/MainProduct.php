<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MainProduct extends Model
{
    protected $fillable = [
        'category_id', 'name', 'sku', 'is_variant'
    ];

    /**
     * Has many relation to products
     *
     * @return collection
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Reverse one to many to table categories
     *
     * @return collection
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Many to many to table variants
     *
     * @return collection
     */
    public function variants()
    {
        return $this->belongsToMany(Variant::class);
    }
}
