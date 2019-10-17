<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(SalesTableSeeder::class);
        $this->call(ExpensesTableSeeder::class);
        $this->call(AdvanceTableSeeder::class);
        $this->call(ProductsAndServicesSeeder::class);
    }
}
