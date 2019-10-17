<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SettingsCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings_company', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->primary('id');
            $table->integer('setting_id')->default('1');
            $table->string('company_name');
            $table->string('company_legal_name');
            $table->string('company_business_id_no');
            $table->string('company_tax_form');
            $table->string('company_industry');
            $table->string('company_email')->unique();
            $table->string('company_customer_facing_email');
            $table->string('company_phone');
            $table->string('company_website');
            $table->string('company_address');
            $table->string('company_customer_facing_address');
            $table->string('company_legal_address');
            $table->string('company_logo')->nullable();
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
        Schema::dropIfExists('settings_company');
    }
}
