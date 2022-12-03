<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorRecords = [
            [
                'id' => 1,
                'name' => 'Virgi',
                'address' => 'GSP',
                'city' => 'Jakarta',
                'state' => 'Central Jakarta',
                'country' => 'Indonesia',
                'pincode' => '10110',
                'mobile' => '12345678910',
                'email' => 'virgi@virgi.com',
                'confirm' => 'No',
                'status' => 0,




            ]
        ];

        Vendor::insert($vendorRecords);
    }
}
