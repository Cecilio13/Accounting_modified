<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStCreditNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_credit_notes', function (Blueprint $table) {
            $table->increments('st_cn_id');
            $table->integer('st_cn_no')->unsigned();
            $table->foreign('st_cn_no')
                    ->references('st_no')
                    ->on('sales_transaction')
                    ->onDelete('cascade');
            $table->integer('st_cn_product')->unsigned();
            $table->foreign('st_cn_product')
                    ->references('product_id')
                    ->on('products_and_services')
                    ->onDelete('cascade');
            $table->string('st_cn_desc');
            $table->integer('st_cn_qty');
            $table->string('st_cn_rate');
            $table->string('st_cn_total');
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
        Schema::dropIfExists('st_credit_notes');
    }
}
