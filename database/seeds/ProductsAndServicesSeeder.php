<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ProductsAndServicesSeeder extends Seeder
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
                'product_id' => '1',
                'product_name' => 'Magic Sarap',
                'product_sku' => '00000',
                'product_type' => 'Food',
                'product_sales_description' => 'Pampa lasa sa pagkaon',
                'product_sales_price' => '20.00',
                'product_cost' => '15.00',
                'product_qty' => '50',
                'product_reorder_point' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'product_id' => '2',
                'product_name' => 'Rice',
                'product_sku' => '11111',
                'product_type' => 'Food',
                'product_sales_description' => 'Pagkaon',
                'product_sales_price' => '50.00',
                'product_cost' => '45.00',
                'product_qty' => '50',
                'product_reorder_point' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
            array(
                'product_id' => '3',
                'product_name' => 'Spoon and fork',
                'product_sku' => '33333',
                'product_type' => 'Utensils',
                'product_sales_description' => 'Pang kaon',
                'product_sales_price' => '30.00',
                'product_cost' => '25.00',
                'product_qty' => '50',
                'product_reorder_point' => '1',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
        );

        DB::table('products_and_services')->insert($data);
    }
}
