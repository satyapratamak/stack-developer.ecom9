<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductsAttributes;

class ProductsAttributesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $productsAttributesRecords = [
            [
                'id' => 1,
                'product_id' => 2,
                'size' => 'Small',
                'price' => 10000,
                'stock' => 200,
                'sku' => 'RC001-S',
                'status' => 1,
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'size' => 'Medium',
                'price' => 10000,
                'stock' => 200,
                'sku' => 'RC001-M',
                'status' => 1,
            ],
            [
                'id' => 3,
                'product_id' => 2,
                'size' => 'Large',
                'price' => 10000,
                'stock' => 200,
                'sku' => 'RC001-L',
                'status' => 1,
            ],
        ];
        ProductsAttributes::insert($productsAttributesRecords);
    }
}
