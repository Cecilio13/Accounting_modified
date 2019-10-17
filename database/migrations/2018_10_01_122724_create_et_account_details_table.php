<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtAccountDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('et_account_details', function (Blueprint $table) {
            $table->increments('et_ad_id');
            $table->integer('et_ad_no')->unsigned();
            $table->foreign('et_ad_no')
                    ->references('et_no')
                    ->on('expense_transactions')
                    ->onDelete('cascade');
            $table->string('et_ad_product');
            $table->string('et_ad_desc');
            $table->integer('et_ad_qty')->nullable();;
            $table->string('et_ad_rate')->nullable();;
            $table->string('et_ad_total');
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
        Schema::dropIfExists('et_account_details');
    }
}
