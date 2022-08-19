<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id')->select('id', 'name');
    }

    public function parentCategory()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id')->select('id', 'category_name');
    }

    public function subCategories()
    {
        return $this->hasMany('App\Models\Category', 'parent_id')->where('status', 1);
    }

    public static function categoryDetails($url)
    {
        $categoryDetails = Category::select('id', 'category_name', 'url')->with('subCategories')->where('url', $url)->first()->toArray();

        $catIds = array();
        $catIds[] = $categoryDetails['id'];


        foreach ($categoryDetails['sub_categories'] as $key => $subcat) {
            $catIds[] = $subcat['id'];
        }

        $resp = array('catIds' => $catIds, 'categoryDetails' => $categoryDetails);
        return $resp;
    }
}
