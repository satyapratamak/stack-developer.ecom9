<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function section()
    {
        return $this->belongsTo('App\Models\Section', 'section_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function attributes()
    {
        // relation 1 product have many attributes
        return $this->hasMany('App\Models\ProductsAttributes', 'product_id', 'id');
    }

    public function images()
    {
        // relation 1 product have many images
        return $this->hasMany('App\Models\ProductsImages', 'product_id', 'id');
    }
}
