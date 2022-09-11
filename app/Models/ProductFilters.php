<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFilters extends Model
{
    use HasFactory;

    public static function getProductFiltersName($id)
    {
        $getProductFiltersName = ProductFilters::select('filter_name')->where('id', $id)->first();
        return $getProductFiltersName->filter_name;
    }

    public function filterValues()
    {
        return $this->hasMany('App\Models\ProductFiltersValues', 'product_filters_id');
    }

    public static function productFilters()
    {
        $productFilters = ProductFilters::with('filterValues')->where('status', 1)
            ->get()->toArray();
        //dd($productFilters);
        return $productFilters;
    }

    public static function filterAvailable($filter_id, $category_id)
    {
        $available = false;
        $filterAvailable = ProductFilters::select('category_id')
            ->where(['id' => $filter_id, 'status' => 1])->first()->toArray();
        $catIdsArr = explode(",", $filterAvailable['category_id']);

        if (in_array($category_id, $catIdsArr)) {
            $available = true;
        }

        return $available;
    }
}
