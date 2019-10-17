<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expense_transactions', function (Blueprint $table) {
            $table->integer('et_no')->unsigned();
            $table->primary('et_no');
            $table->integer('et_customer')->unsigned();
            $table->foreign('et_customer')
                    ->references('customer_id')
                    ->on('customers')
                    ->onDelete('cascade');
            $table->string('et_email')->nullable();
            $table->string('et_billing_address')->nullable();
            $table->string('et_account')->nullable();
            $table->string('et_payment_method')->nullable();
            $table->string('et_terms')->nullable();
            $table->date('et_date')->nullable();
            $table->date('et_due_date')->nullable();
            $table->string('et_bill_no')->nullable();
            $table->string('et_message')->nullable();
            $table->string('et_memo')->nullable();
            $table->string('et_attachment')->nullable();
            $table->string('et_reference_no')->nullable();
            $table->string('et_shipping_address')->nullable();
            $table->string('et_shipping_to')->nullable();
            $table->string('et_shipping_via')->nullable();
            $table->string('et_type')->nullable();
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
        Schema::dropIfExists('expense_transactions');
    }
}
