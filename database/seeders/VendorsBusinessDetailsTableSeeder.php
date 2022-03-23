<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetails;

class VendorsBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorBusinessDetailsRecords = [
            [
                'id' => 1,
                'vendor_id' => 1,
                'shop_name' => 'Virgi Electronics Store',
                'shop_address' => '1234-SCF',
                'shop_city' => 'Jakarta',
                'shop_state' => 'Central Jakarta',
                'shop_country' => 'Indonesia',
                'shop_pincode' => '10110',
                'shop_mobile' => '12345678910',
                'shop_website' => 'www.virgi.com',
                'shop_email' => 'virgi@virgi.com',
                'address_proof' => 'Passport',
                'address_proof_image' => 'test.jpg',
                'business_license_number' => '12345',
                'gst_number' => '123456',
                'pan_number' => '1234567',

            ],
        ];

        VendorsBusinessDetails::insert($vendorBusinessDetailsRecords);
    }
}
