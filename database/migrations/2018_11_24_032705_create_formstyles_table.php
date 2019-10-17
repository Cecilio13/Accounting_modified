<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormstylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_form_style', function (Blueprint $table) {
            $table->integer('cfs_id')->unsigned();
            $table->primary('cfs_id');
            $table->string('cfs_name');
            $table->enum('cfs_design_template', ['1', '2','3'])->default('1');
            $table->string('cfs_logo_name')->nullable();
            $table->enum('cfs_logo_show', ['1', '0'])->default('0');
            $table->string('cfs_logo_size')->nullable();
            $table->string('cfs_logo_alignment')->nullable();
            $table->string('cfs_theme_color')->nullable();
            $table->string('cfs_font_family')->nullable();
            $table->string('cfs_font_size')->nullable();
            $table->string('cfs_margin')->nullable();
            $table->enum('cfs_company_name_check', ['1','0'])->default('1');
            $table->string('cfs_company_name_value')->nullable();
            $table->enum('cfs_phone_check', ['1','0'])->default('1');
            $table->string('cfs_phone_value')->nullable();
            $table->enum('cfs_email_check', ['1','0'])->default('1');
            $table->string('cfs_email_value')->nullable();
            $table->enum('cfs_crn_check', ['1','0'])->default('1');
            $table->string('cfs_crn_value')->nullable();
            $table->enum('cfs_business_address_check', ['1','0'])->default('1');
            $table->enum('cfs_website_check', ['1','0'])->default('1');
            $table->string('cfs_website_value')->nullable();
            $table->enum('cfs_form_name_check', ['1','0'])->default('1');
            $table->string('cfs_form_name_value')->nullable();
            $table->enum('cfs_form_number_check', ['1','0'])->default('1');
            $table->enum('cfs_shipping_check', ['1','0'])->default('1');
            $table->enum('cfs_terms_check', ['1','0'])->default('1');
            $table->enum('cfs_duedate_check', ['1','0'])->default('1');
            $table->enum('cfs_table_date_check', ['1','0'])->default('1');
            $table->enum('cfs_table_product_check', ['1','0'])->default('1');
            $table->enum('cfs_table_desc_check', ['1','0'])->default('1');
            $table->enum('cfs_table_qty_check', ['1','0'])->default('1');
            $table->enum('cfs_table_rate_check', ['1','0'])->default('1');
            $table->enum('cfs_table_amount_check', ['1','0'])->default('1');
            $table->string('cfs_footer_message_value')->nullable();
            $table->string('cfs_footer_message_font_size')->nullable();
            $table->string('cfs_footer_text_value')->nullable();
            $table->string('cfs_footer_text_font_size')->nullable();
            $table->string('cfs_footer_text_position')->nullable();

            $table->string('cfs_email_subject')->nullable();
            $table->enum('cfs_email_use_greeting', ['1','0'])->default('1');
            $table->string('cfs_email_greeting_pronoun')->nullable();
            $table->string('cfs_email_greeting_word')->nullable();
            $table->text('cfs_email_message')->nullable();
            $table->enum('cfs_status', ['1','0'])->default('1');
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
        Schema::dropIfExists('custom_form_style');
    }
}
