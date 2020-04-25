<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrinterSetting extends Model
{
    protected $fillable = [
        'printer_name',
        'printer_ip'
    ];
}
