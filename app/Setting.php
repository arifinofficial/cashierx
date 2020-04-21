<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'store_name',
        'store_email',
        'store_phone',
        'store_address',
        'store_logo',
    ];
}
