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
            // [
            //     'id' => 1,
            //     'name' => 'Super Admin',
            //     'type' => 'superadmin',
            //     'vendor_id' => 0,
            //     'mobile' => '980000000',
            //     'email' => 'admin@admin.com',
            //     'password' => '$2a$12$G6S8xJuqH3Rf6p8g/TC9vugmb6f7XNIF.1wUpBvOg0.yjqsWbI1xy',
            //     'image' => '',
            //     'status' => 1,
            // ],
             [
                'id' => 2,
                'name' => 'Virgi',
                'type' => 'vendor',
                'vendor_id' => 1,
                'mobile' => '12345678910',
                'email' => 'virgi@virgi.com',
                'password' => '$2a$12$slAZlAAGFq4DR7CpB65ExuNfcGgdN/bB9aQDG097nSClBVYJZl92e',
                'image' => '',
                'status' => 0,
            ],

        ];
        Admin::insert($adminRecords);
    }
}
