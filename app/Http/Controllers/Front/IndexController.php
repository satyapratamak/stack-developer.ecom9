<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Banner;
use App\Models\Product;

class IndexController extends Controller
{
    public function index()
    {

        $sections = Section::sections();
        $banners = Banner::banners();

        $sliderBanners = Banner::sliderBanners();
        $fixBanners = Banner::fixBanners();

        $newLimitProducts = Product::newLimitProducts(8);
        $bestSellerProducts = Product::bestSellerProducts();
        $discountedProducts = Product::discountedProducts(6);

        // dd($newLimitProducts);
        return view('front.index')->with(compact('sections', 'banners', 'sliderBanners', 'fixBanners', 'newLimitProducts', 'bestSellerProducts', 'discountedProducts'));
    }
}
