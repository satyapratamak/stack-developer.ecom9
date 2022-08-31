<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Section;

class ProductsController extends Controller
{
    //
    public function listing(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();

            $url = $data['url'];
            $_GET['sort'] = $data['sort'];
            $sections = Section::sections();

            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {

                $categoryDetails = Category::categoryDetails($url);

                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);

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

                $categoryProducts = $categoryProducts->paginate(3);

                return view('front.products.ajax_products_listing')->with(compact('categoryProducts', 'categoryDetails', 'sections', 'url'));
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

                $categoryProducts = $categoryProducts->paginate(3);

                return view('front.products.listing')->with(compact('categoryProducts', 'categoryDetails', 'sections', 'url'));
            } else {
                abort(404);
            }
        }
    }
}
