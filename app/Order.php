<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user',
        'invoice',
        'sub_total',
        'total',
        'cash',
        'total_change',
        'discount_name',
        'discount_value',
        'order_status',
    ];

    protected $dates =['deleted_at'];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
