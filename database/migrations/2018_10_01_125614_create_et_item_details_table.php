<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtItemDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('et_item_details', function (Blueprint $table) {
            $table->increments('et_id_id');
            $table->integer('et_id_no')->unsigned();
            $table->foreign('et_id_no')
                    ->references('et_no')
                    ->on('expense_transactions')
                    ->onDelete('cascade');
            $table->integer('et_id_product')->unsigned();
            $table->foreign('et_id_product')
                    ->references('product_id')
                    ->on('products_and_services')
                    ->onDelete('cascade');
            $table->string('et_id_desc');
            $table->integer('et_id_qty');
            $table->string('et_id_rate');
            $table->string('et_id_total');
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
        Schema::dropIfExists('et_item_details');
    }
}
