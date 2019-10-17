<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Customers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->integer('customer_id')->unsigned();
            $table->primary('customer_id');
            $table->string('f_name');
            $table->string('l_name');
            $table->string('email');
            $table->string('company');
            $table->string('phone');
            $table->string('mobile');
            $table->string('fax');
            $table->string('display_name');
            $table->string('other');
            $table->string('website');
            $table->string('street');
            $table->string('city');
            $table->string('state');
            $table->string('postal_code');
            $table->string('country');
            $table->string('payment_method');
            $table->string('terms');
            $table->string('opening_balance');
            $table->date('as_of_date');
            $table->string('account_no');
            $table->string('business_id_no');
            $table->string('notes');
            $table->string('attachment')->nullable();
            $table->string('tin_no');
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
        Schema::dropIfExists('customers');
    }
}
