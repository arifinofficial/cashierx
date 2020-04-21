<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainProductVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_product_variant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_product_id')->unsigned();
            $table->foreignId('variant_id')->unsigned();
            $table->timestamps();

            $table->foreign('main_product_id')->references('id')->on('main_products')->onDelete('cascade');
            $table->foreign('variant_id')->references('id')->on('variants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_product_variant');
    }
}
