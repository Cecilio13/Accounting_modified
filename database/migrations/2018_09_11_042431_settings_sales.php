<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_sales', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->primary('id');
            $table->integer('setting_id')->default('1');
            $table->string('sales_preferred_invoice_term');
            $table->string('sales_preferred_delivery_method');
            $table->string('sales_shipping');
            $table->string('sales_custom_field');
            $table->string('sales_custom_transaction_number');
            $table->string('sales_service_date');
            $table->string('sales_discount');
            $table->string('sales_deposit');
            $table->string('sales_show_product_column');
            $table->string('sales_show_sku_column');
            $table->string('sales_track_quantity_and_price');
            $table->string('sales_track_quantity_on_hand');
            $table->string('sales_form_email_message');
            $table->string('sales_default_reminder_message');
            $table->string('sales_email_option');
            $table->string('sales_show_aging_table');
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
        Schema::dropIfExists('settings_sales');
    }
}
