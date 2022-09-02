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
}
