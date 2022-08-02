<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function attributes()
    {
        // relation 1 product have many attributes
        return $this->hasMany('App\Models\ProductsAttributes', 'product_id', 'id');
    }

    public function images()
    {
        // relation 1 product have many images
        return $this->hasMany('App\Models\ProductsImages', 'product_id', 'id');
    }

    public static function newLimitProducts($limit)
    {
        $newLimitProducts = Product::orderBy('id', 'Desc')->where('status', 1)->limit($limit)->get()->toArray();
        return $newLimitProducts;
    }

    public static function getDiscountPrice($product_id)
    {
        $proDetails = Product::select('product_price', 'product_discount', 'category_id')->where('id', $product_id)->first();
        $proDetails = json_decode(json_encode($proDetails), true);

        $catDetails = Category::select('category_discount')->where('id', $proDetails['category_id'])->first();
        $catDetails = json_decode(json_encode($catDetails), true);

        $discounted_price = 0;

        if ($proDetails['product_discount'] > 0) {
            // product discount is added from admin panel
            $discounted_price = $proDetails['product_price'] * (100 - $proDetails['product_discount']) / 100;
        } else if ($catDetails['category_discount'] > 0) {
            // product discount is not added but category discount is added
            $discounted_price = $proDetails['product_price'] * (100 - $catDetails['category_discount']) / 100;
        }
        return $discounted_price;
    }
}
