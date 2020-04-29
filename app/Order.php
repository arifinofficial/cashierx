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
        'total',
        'cash',
        'total_change',
    ];

    protected $dates =['deleted_at'];

    public function orderDetail()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
