<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $categoryRecords = [
            [
                'id' => 1,
                'parent_id' => 0,
                'section_id' => 1,
                'category_name' => 'Men',
                'category_image' => '',
                'category_discount' => 0,
                'description' => '',
                'url' => 'men',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 1,
            ],

            [
                'id' => 2,
                'parent_id' => 0,
                'section_id' => 1,
                'category_name' => 'Women',
                'category_image' => '',
                'category_discount' => 0,
                'description' => '',
                'url' => 'women',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 1,
            ],
            [
                'id' => 3,
                'parent_id' => 0,
                'section_id' => 1,
                'category_name' => 'Kids',
                'category_image' => '',
                'category_discount' => 0,
                'description' => '',
                'url' => 'kids',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 1,
            ],
            [
                'id' => 4,
                'parent_id' => 0,
                'section_id' => 2,
                'category_name' => 'Mobiles',
                'category_image' => '',
                'category_discount' => 0,
                'description' => '',
                'url' => 'kids',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 1,
            ],
            [
                'id' => 5,
                'parent_id' => 4,
                'section_id' => 2,
                'category_name' => 'Smartphones',
                'category_image' => '',
                'category_discount' => 0,
                'description' => '',
                'url' => 'kids',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 1,
            ],
            [
                'id' => 6,
                'parent_id' => 1,
                'section_id' => 1,
                'category_name' => 'T-Shirts',
                'category_image' => '',
                'category_discount' => 0,
                'description' => '',
                'url' => 'kids',
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'status' => 1,
            ],

        ];
        Category::insert($categoryRecords);
    }
}
