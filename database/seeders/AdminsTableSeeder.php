<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'type' => 'superadmin',
                'vendor_id' => 0,
                'mobile' => '980000000',
                'email' => 'admin@admin.com',
                'password' => '$2a$12$G6S8xJuqH3Rf6p8g/TC9vugmb6f7XNIF.1wUpBvOg0.yjqsWbI1xy',
                'image' => '',
                'status' => 1,
            ]

        ];
        Admin::insert($adminRecords);
    }
}
