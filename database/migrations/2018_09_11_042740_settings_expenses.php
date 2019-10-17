<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsExpenses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_expenses', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->primary('id');
            $table->integer('setting_id')->default('1');
            $table->string('expenses_show_items_table');
            $table->string('expenses_track_expense_and_item_by_customer');
            $table->string('expenses_billable');
            $table->string('expenses_bill_payment_terms')->nullable();
            $table->string('expenses_use_purchase_order');
            $table->string('expenses_purchase_order_email_message');
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
        Schema::dropIfExists('settings_expenses');
    }
}
