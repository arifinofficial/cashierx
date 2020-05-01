<?php

namespace App\Data;

use App\MainProduct;
use App\Setting;
use App\PrinterSetting;
use App\Product;
use App\Order;
use Carbon\Carbon;

class Core
{
    /**
     * Check main product type
     *
     * @return Collection
     */
    public function isVariant()
    {
        $model = MainProduct::findOrFail(request('main_product'));

        if ($model->is_variant === 1) {
            return true;
        }

        return false;
    }

    public function getRelatedMainProductVariant()
    {
        $model = MainProduct::findOrFail(request('main_product'))->variants()->get();

        return $model;
    }

    public function getAllSettings()
    {
        $model = Setting::first();

        return $model;
    }

    public function printerSetting()
    {
        $model = PrinterSetting::get();

        $model = $model->last();

        return $model;
    }

    /**
     * Get omzet mounth
     *
     * @return Collection
     */
    public function getOmzetMounth()
    {
        $monthNow = date('m');
        $yearNow = date('Y');

        $model = Order::whereYear('created_at', $yearNow)->whereMonth('created_at', $monthNow)->get();

        $total = $model->sum('total');
        
        return $total;
    }

    /**
     * Get omzet day
     *
     * @return Collection
     */
    public function getOmzetDay()
    {
        $now = date('Y-m-d');

        $model = Order::whereDate('created_at', $now)->get();

        $total = $model->sum('total');
        
        return $total;
    }

    /**
     * Get total transaction /day
     *
     * @return Collection
     */
    public function countTransaction()
    {
        $now = date('Y-m-d');

        $model = Order::whereDate('created_at', $now)->get();

        $total = count($model);
        
        return $total;
    }

    /**
     * Count total product
     *
     * @return Collection
     */
    public function countProduct()
    {
        $model = Product::all();

        $total = count($model);
        
        return $total;
    }

    /**
     * Get limit transaction order
     *
     * @return Collection
     */
    public function limitTransaction()
    {
        $model = Order::with('orderDetail')->orderBy('created_at', 'DESC')->take(6)->get();
       
        return $model;
    }
}
