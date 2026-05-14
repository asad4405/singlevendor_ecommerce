<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class,'color_id')
        ->select('id','color_name','color_code');
    }

    public function size()
    {
        return $this->belongsTo(Size::class,'size_id')
        ->select('id','size_name');
    }

    public function colors()
    {
        return $this->hasMany(Color::class, 'id')
        ->select('id','color_name','color_code');
    }
    public function sizes()
    {
        return $this->hasMany(Size::class, 'id')
        ->select('id','size_name');
    }
}
