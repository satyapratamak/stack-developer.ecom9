<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetails;

class VendorsBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vendorBankDetailsRecords = [
            [
                'id' => 1,
                'vendor_id' => 1,
                'account_holder_name' => 'Virgi',
                'bank_name' => 'Bank Mandiri',
                'account_number' => '987654321',
                'bank_ifsc_code' => '7654321',


            ],
        ];

        VendorsBankDetails::insert($vendorBankDetailsRecords);
    }
}
