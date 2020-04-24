<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user',
        'invoice',
        'total',
        'cash',
        'total_change',
    ];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
