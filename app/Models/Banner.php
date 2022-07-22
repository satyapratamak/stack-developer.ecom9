<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    public static function banners()
    {
        $getBanners = Banner::where("status", 1)->get()->toArray();
        return $getBanners;
    }

    public static function sliderBanners()
    {
        $sliderBanners = Banner::where("type", "Slider")->where("status", 1)->get()->toArray();
        return $sliderBanners;
    }

    public static function fixBanners()
    {
        $fixBanners = Banner::where("type", "Fix")->where("status", 1)->get()->toArray();
        return $fixBanners;
    }
}
