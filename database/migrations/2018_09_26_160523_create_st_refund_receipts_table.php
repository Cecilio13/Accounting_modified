<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStRefundReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_refund_receipts', function (Blueprint $table) {
            $table->increments('st_r_id');
            $table->integer('st_r_no')->unsigned();
            $table->foreign('st_r_no')
                    ->references('st_no')
                    ->on('sales_transaction')
                    ->onDelete('cascade');
            $table->integer('st_r_product')->unsigned();
            $table->foreign('st_r_product')
                    ->references('product_id')
                    ->on('products_and_services')
                    ->onDelete('cascade');
            $table->string('st_r_desc');
            $table->integer('st_r_qty');
            $table->string('st_r_rate');
            $table->string('st_r_total');
            $table->string('st_p_method')->nullable();
            $table->string('st_p_reference_no')->nullable();
            $table->string('st_p_deposit_to')->nullable();
            $table->string('st_p_amount')->default('0')->nullable();
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
        Schema::dropIfExists('st_refund_receipts');
    }
}
