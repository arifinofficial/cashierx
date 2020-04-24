<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $fillable = [
        'product_id',
        'order_id',
        'price',
        'qty',
        'product_name',
        'variant'
    ];
}
