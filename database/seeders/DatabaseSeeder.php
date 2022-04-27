<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();
        // $this->call(AdminsTableSeeder::class);
        // $this->call(VendorsTableSeeders::class);
        //$this->call(VendorsBusinessDetailsTableSeeder::class);
        // $this->call(VendorsBankDetailsTableSeeder::class);
        $this->call(SectionTableSeeder::class);
    }
}
