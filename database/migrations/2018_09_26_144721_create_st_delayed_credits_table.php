<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStDelayedCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('st_delayed_credits', function (Blueprint $table) {
            $table->increments('st_dcredit_id');
            $table->integer('st_dcredit_no')->unsigned();
            $table->foreign('st_dcredit_no')
                    ->references('st_no')
                    ->on('sales_transaction')
                    ->onDelete('cascade');
            $table->integer('st_dcredit_product')->unsigned();
            $table->foreign('st_dcredit_product')
                    ->references('product_id')
                    ->on('products_and_services')
                    ->onDelete('cascade');
            $table->string('st_dcredit_desc');
            $table->integer('st_dcredit_qty');
            $table->string('st_dcredit_rate');
            $table->string('st_dcredit_total');
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
        Schema::dropIfExists('st_delayed_credits');
    }
}
