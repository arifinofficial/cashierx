<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Many to many to table main_products
     *
     * @return collection
     */
    public function mainProducts()
    {
        return $this->belongsToMany(MainProduct::class);
    }
}
