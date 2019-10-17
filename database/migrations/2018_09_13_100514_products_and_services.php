<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductsAndServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_and_services', function (Blueprint $table) {
            $table->integer('product_id')->unsigned();
            $table->primary('product_id');
            $table->string('product_name');
            $table->string('product_sku');
            $table->string('product_type');
            $table->string('product_sales_description');
            $table->string('product_sales_price');
            $table->string('product_cost');
            $table->integer('product_qty');
            $table->string('product_reorder_point');
            $table->timestamps();
        });   
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products_and_services');
    }
}
