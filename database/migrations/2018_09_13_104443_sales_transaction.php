<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SalesTransaction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_transaction', function (Blueprint $table) {
            $table->integer('st_no')->unsigned();
            $table->primary('st_no');
            $table->date('st_date')->nullable();
            $table->string('st_type')->nullable();
            $table->string('st_term')->nullable();
            $table->integer('st_customer_id')->unsigned();
            $table->foreign('st_customer_id')
                    ->references('customer_id')
                    ->on('customers')
                    ->onDelete('cascade');
            $table->date('st_due_date')->nullable();
            $table->string('st_status')->nullable();
            $table->string('st_action')->nullable();
            $table->string('st_email')->nullable();
            $table->string('st_send_later')->nullable();
            $table->string('st_bill_address')->nullable();
            $table->string('st_note')->nullable();
            $table->string('st_memo')->nullable();
            $table->string('st_balance')->nullable();
            $table->string('st_amount_paid')->nullable();
            $table->string('st_payment_for')->nullable();
            $table->string('st_i_attachment')->nullable();
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
        Schema::dropIfExists('sales_transaction');
    }
}
