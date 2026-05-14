<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id')->where('status', 1)->select('id', 'category_id', 'subcategory_name', 'slug', 'image');
    }
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id')
            ->select('id', 'category_id', 'subcategory_id', 'childcategory_id', 'product_name', 'slug', 'product_image', 'product_type', 'old_price', 'new_price')
            ->where('status', 1);
    }
}
