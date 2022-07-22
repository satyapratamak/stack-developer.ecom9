<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Banner;

class IndexController extends Controller
{
    public function index()
    {

        $sections = Section::sections();
        $banners = Banner::banners();

        $sliderBanners = Banner::sliderBanners();
        $fixBanners = Banner::fixBanners();


        return view('front.index')->with(compact('sections', 'banners', 'sliderBanners', 'fixBanners'));
    }
}
