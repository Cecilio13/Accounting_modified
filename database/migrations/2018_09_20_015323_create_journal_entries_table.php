<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journal_entries', function (Blueprint $table) {
            $table->integer('je_id')->unsigned();
            
            $table->integer('je_no');
            $table->string('je_account');
            $table->string('je_debit')->nullable()->default(null);
            $table->string('je_credit')->nullable()->default(null);
            $table->string('je_desc');
            $table->string('je_name');
            $table->string('je_memo')->nullable()->default(null);
            $table->string('je_attachment')->nullable()->default(null);
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
        Schema::dropIfExists('journal_entries');
    }
}
