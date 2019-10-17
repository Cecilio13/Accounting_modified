<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SalesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'id' => '1',
                'setting_id' => '1',
                'sales_preferred_invoice_term' => 'Net 30',
                'sales_preferred_delivery_method' => 'None',
                'sales_shipping' => 'Off',
                'sales_custom_field' => 'Off',
                'sales_custom_transaction_number' => 'Off',
                'sales_service_date' => 'Off',
                'sales_discount' => 'Off',
                'sales_deposit' => 'Off',
                'sales_show_product_column' => 'On',
                'sales_show_sku_column' => 'Off',
                'sales_track_quantity_and_price' => 'Off',
                'sales_track_quantity_on_hand' => 'Off',
                'sales_form_email_message' => 'Default email message sent with sales forms',
                'sales_default_reminder_message' => 'Default email message sent with reminders',
                'sales_email_option' => 'Email options for sales forms',
                'sales_show_aging_table' => 'On',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
        );

        DB::table('settings_sales')->insert($data);
    }
}
