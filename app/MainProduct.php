<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MainProduct extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id', 'name', 'sku', 'is_variant'
    ];

    protected $dates =['deleted_at'];

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
