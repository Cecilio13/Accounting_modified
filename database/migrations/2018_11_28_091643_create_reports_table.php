<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->integer('report_id')->unsigned();
            $table->primary('report_id');
            $table->string('report_name')->nullable();
            $table->string('report_header')->nullable();
            $table->string('report_title')->nullable();
            $table->string('report_type')->nullable();
            $table->enum('report_show_note', ['1','0'])->default('0');
            $table->string('report_note')->nullable();
            $table->string('report_sort_by')->nullable();
            $table->string('report_sort_order')->nullable();
            $table->string('report_table_column')->nullable();
            $table->string('report_content_from')->nullable();
            $table->string('report_content_to')->nullable();
            $table->string('report_content_filter')->nullable();
            $table->enum('report_status', ['1','0'])->default('1');
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
        Schema::dropIfExists('reports');
    }
}
