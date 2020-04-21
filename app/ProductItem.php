<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductItem extends Model
{
    protected $fillable = [
        'product_id',
        'unit_id',
        'name',
        'recipe',
    ];

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
