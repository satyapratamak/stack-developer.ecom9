<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductsController extends Controller
{
    //
    public function listing()
    {
        $url = Route::getFacadeRoot()->current()->uri();
        $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
        if ($categoryCount > 0) {
            $categoruDetails = Category::categoryDetails($url);
            echo "Category Exists";
        } else {
            abort(404);
        }
    }
}
