<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_product_id')->unsigned();
            $table->string('name');
            $table->string('sku')->nullable();
            $table->string('picture')->nullable();
            $table->string('variant')->nullable();
            $table->boolean('is_active')->nullable()->default(1);
            $table->decimal('price', 19, 2);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('main_product_id')->references('id')->on('main_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
