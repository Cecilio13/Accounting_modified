<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'settings_sales';
    protected $fillable = array(
        'id',
        'setting_id',
        'sales_preferred_invoice_term',
        'sales_preferred_delivery_method',
        'sales_shipping',
        'sales_custom_field',
        'sales_custom_transaction_number',
        'sales_service_date',
        'sales_discount',
        'sales_deposit',
        'sales_show_product_column',
        'sales_show_sku_column',
        'sales_track_quantity_and_price',
        'sales_track_quantity_on_hand',
        'sales_form_email_message',
        'sales_default_reminder_message',
        'sales_email_option',
        'sales_show_aging_table'
    );

    public $timestamps = true;
}
