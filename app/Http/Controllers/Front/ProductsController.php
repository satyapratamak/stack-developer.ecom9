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
    public function listing()
    {
        $url = Route::getFacadeRoot()->current()->uri();
        $sections = Section::sections();

        $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
        if ($categoryCount > 0) {

            $categoryDetails = Category::categoryDetails($url);

            $categoryProducts = Product::whereIn('category_id', $categoryDetails['catIds'])->where('status', 1)->get()->toArray();

            return view('front.products.listing')->with(compact('categoryProducts', 'categoryDetails', 'sections'));
        } else {
            abort(404);
        }
    }
}
