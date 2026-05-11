<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $guarded = ['id'];

    public function category()
    {
        return $this->BelongsTo(Category::class,'category_id');
    }
    public function image()
    {
        return $this->hasOne(SliderImage::class, 'product_id')->select('id','slider_image','product_id');
    }
    public function inventory()
    {
        return $this->hasMany(Inventory::class, 'product_id')->where('status', 1)
        ->select('id','product_id','color_id','size_id','price','old_price');
    }
}
