<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    public function childcategories()
    {
        return $this->hasMany(Childcategory::class, 'subcategory_id')->where('status', 1)->select('id','subcategory_id','slug','childcategory_name','image');
    }
}
