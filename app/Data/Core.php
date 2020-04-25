<?php

namespace App\Data;

use App\MainProduct;
use App\Setting;
use App\PrinterSetting;

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
        $model = PrinterSetting::first();

        return $model;
    }
}
