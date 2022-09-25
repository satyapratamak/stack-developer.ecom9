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

                if (isset($data['size']) && !empty($data['size'])) {
                    $productIds = ProductsAttributes::select('product_id')->whereIn('size', $data['size'])->pluck('product_id')->toArray();
                    $categoryProducts->whereIn('id', $productIds);
                }

                if (isset($data['color']) && !empty($data['color'])) {
                    $productIds = Product::select('id')->whereIn('product_color', $data['color'])->pluck('id')->toArray();
                    $categoryProducts->whereIn('id', $productIds);
                }

                if (isset($data['price']) && !empty($data['price'])) {

                    $implodePrices = implode('-', $data['price']);
                    $explodePrices = explode('-', $implodePrices);

                    $productIds = Product::select('id');

                    if (count($explodePrices) == 1) {

                        $productIds->where('product_price', '>', 100000);
                    } else if ((count($explodePrices) % 2) != 0) {

                        array_pop($explodePrices);
                        array_push($explodePrices, '100000');
                        array_push($explodePrices, '2147483647');

                        $min = reset($explodePrices);
                        $max = end($explodePrices);
                        $productIds->whereBetween('product_price', [$min, $max]);
                    } else {
                        $min = reset($explodePrices);
                        $max = end($explodePrices);
                        $productIds->whereBetween('product_price', [$min, $max]);
                    }

                    $productIds->pluck('id')->toArray();

                    $categoryProducts->whereIn('id', $productIds);
                }

                //$categoryProducts = $categoryProducts->paginate(3);
                $categoryProducts = $categoryProducts->get()->toArray();
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
                $prices = array('0-1000', '1000-2000', '2000-5000', '5000-10000', '10000-100000', '> 100000');


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
                $categoryProducts = $categoryProducts->get()->toArray();

                return view('front.products.listing')->with(compact('categoryProducts', 'categoryDetails', 'sections', 'url', 'productFilters', 'getSizes', 'getColors', 'prices'));
                //return view('front.products.listing')->with(compact('categoryProducts', 'categoryDetails', 'sections', 'url', 'productFilters'));
            } else {
                abort(404);
            }
        }
    }
}
