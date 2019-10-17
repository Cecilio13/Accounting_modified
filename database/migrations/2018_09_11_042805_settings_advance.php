<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsAdvance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_advance', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->primary('id');
            $table->integer('setting_id')->default('1');
            $table->string('advance_first_month_of_fiscal_year');
            $table->string('advance_first_month_of_tax_year');
            $table->string('advance_accounting_method');
            $table->string('advance_close_book');
            $table->string('advance_tax_form');
            $table->string('advance_enable_acc_number');
            $table->string('advance_track_classes');
            $table->string('advance_track_location');
            $table->string('advance_prefill_form');
            $table->string('advance_apply_credit');
            $table->string('advance_invoice_unbilled_activity');
            $table->string('advance_apply_bill_payment');
            $table->string('advance_add_service_field');
            $table->string('advance_single_time_activity_billable');
            $table->string('advance_language');
            $table->string('advance_home_currency');
            $table->string('advance_multi_currency');
            $table->string('advance_date_format');
            $table->string('advance_number_format');
            $table->string('advance_dup_cheque_num');
            $table->string('advance_dup_bill_num');
            $table->string('advance_inactive_time');
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
        Schema::dropIfExists('settings_advance');
    }
}
