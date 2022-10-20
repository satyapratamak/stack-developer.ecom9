<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Section;
use App\Models\ProductFilters;
use App\Models\ProductsAttributes;

class ProductsController extends Controller
{
    //
    public function listing(Request $request)
    {
        $productFilters = ProductFilters::productFilters();
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>";
            // print_r($data);
            //die;


            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $sections = Section::sections();



            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {

                $categoryDetails = Category::categoryDetails($url);


                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                // Filter Size
                $getSizes = ProductFilters::getSizes($url);

                // Filter Color
                $getColors = ProductFilters::getColors($url);

                // Prices
                $prices = array('0-1000', '1000-2000', '2000-5000', '5000-10000', '10000 - 100000', '>100000');




                // Checking for Dynamic Filters
                $productFilters = ProductFilters::productFilters();
                foreach ($productFilters as $key => $filter) {
                    if (isset($data[$filter['filter_column']]) && !empty($data[$filter['filter_column']])) {
                        $categoryProducts->whereIn('products.' . $filter['filter_column'], $data[$filter['filter_column']]);
                    }
                }


                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == "product_latest") {
                        $categoryProducts->orderby('products.id', 'DESC');
                    } else if ($_GET['sort'] == "price_lowest") {
                        $categoryProducts->orderby('products.product_price', 'ASC');
                    } else if ($_GET['sort'] == "price_highest") {
                        $categoryProducts->orderby('products.product_price', 'DESC');
                    } else if ($_GET['sort'] == "name_a_z") {
                        $categoryProducts->orderby('products.product_name', 'ASC');
                    } else if ($_GET['sort'] == "name_z_a") {
                        $categoryProducts->orderby('products.product_name', 'DESC');
                    }
                }

                // Checking for size
                if (isset($data['size']) && !empty($data['size'])) {
                    $productIds = ProductsAttributes::select('product_id')->whereIn('size', $data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('id', $productIds);
                }

                // Checking for color
                if (isset($data['color']) && !empty($data['color'])) {
                    $productIds = Product::select('id')->whereIn('product_color', $data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('id', $productIds);
                }

                // Checking for brand
                if (isset($data['brand']) && !empty($data['brand'])) {
                    $productIds = Product::select('id')->whereIn('brand_id', $data['brand'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('id', $productIds);
                }

                // Checking for price
                if (isset($data['price']) && !empty($data['price'])) {

                    foreach ($data['price'] as $key => $price) {

                        if (str_contains($price, '-')) {
                            $priceArr = explode("-", $price);
                        } else {
                            $priceArr = explode("-", "100000-2147483647");
                        }
                        //$priceArr = explode("-", $price);
                        $priceArr =
                            preg_replace("/[^a-zA-Z 0-9]+/", "", $priceArr);
                        $productIds[] = Product::select('id')->whereBetween('product_price', [$priceArr[0], $priceArr[1]])
                            ->pluck('id')->toArray();
                    }


                    $productIds = call_user_func_array('array_merge', $productIds);


                    $categoryProducts->whereIn('id', $productIds);
                }

                $categoryProducts = $categoryProducts->paginate(30);
                return view('front.products.ajax_products_listing')->with(compact('categoryProducts', 'categoryDetails', 'sections', 'url', 'productFilters', 'getSizes', 'getColors'));
                //return view('front.products.ajax_products_listing')->with(compact('categoryProducts', 'categoryDetails', 'sections', 'url', 'productFilters'));
            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $sections = Section::sections();

            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {

                $categoryDetails = Category::categoryDetails($url);

                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

                // Filter Size
                $getSizes = ProductFilters::getSizes($url);

                // Filter Color
                $getColors = ProductFilters::getColors($url);

                // Prices
                $prices = array('0 - 1,000', '1,000 - 2,000', '2,000 - 5,000', ' 5,000 - 10,000', '10,000 - 100,000', '> 100,000');

                // Brands
                $getBrands = ProductFilters::getBrands($url);


                // Checking for sort
                if (isset($_GET['sort']) && !empty($_GET['sort'])) {
                    if ($_GET['sort'] == "product_latest") {
                        $categoryProducts->orderby('products.id', 'DESC');
                    } else if ($_GET['sort'] == "price_lowest") {
                        $categoryProducts->orderby('products.product_price', 'ASC');
                    } else if ($_GET['sort'] == "price_highest") {
                        $categoryProducts->orderby('products.product_price', 'DESC');
                    } else if ($_GET['sort'] == "name_a_z") {
                        $categoryProducts->orderby('products.product_name', 'ASC');
                    } else if ($_GET['sort'] == "name_z_a") {
                        $categoryProducts->orderby('products.product_name', 'DESC');
                    }
                }

                // Checking for size filters
                // if (isset($data['size']) && !empty($data['size'])) {
                // }

                //$categoryProducts = $categoryProducts->paginate(3);
                $categoryProducts = $categoryProducts->paginate(30);
                //$categoryProducts = $categoryProducts->get()->toArray();

                return view('front.products.listing')->with(compact('categoryProducts', 'categoryDetails', 'sections', 'url', 'productFilters', 'getSizes', 'getColors', 'prices', 'getBrands'));
                //return view('front.products.listing')->with(compact('categoryProducts', 'categoryDetails', 'sections', 'url', 'productFilters'));
            } else {
                abort(404);
            }
        }
    }
}
