<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->integer('log_id')->unsigned();
            $table->primary('log_id');
            $table->string('log_user_id')->nullable();
            $table->text('log_event')->nullable();
            $table->string('log_name')->nullable();
            $table->string('log_transaction_date')->nullable();
            $table->string('log_amount')->nullable();
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
        Schema::dropIfExists('audit_logs');
    }
}
