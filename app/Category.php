<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
        'picture',
        'description',
    ];

    /**
     * One to many to table main_products
     *
     * @return collection
     */
    public function mainProducts()
    {
        return $this->hasMany(MainProduct::class);
    }
}
