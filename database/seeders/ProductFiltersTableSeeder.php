<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductFilters;

class ProductFiltersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $filterRecords = [
            [
                'id' => 1,
                'category_id' => '1,2,3,6',
                'filter_name' => 'Fabric',
                'filter_column' => 'fabric',
                'status' => 1,
            ],
            [
                'id' => 2,
                'category_id' => '4,5',
                'filter_name' => 'RAM',
                'filter_column' => 'ram',
                'status' => 1,
            ]
        ];
        ProductFilters::insert($filterRecords);
    }
}
