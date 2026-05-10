<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function orderdetails()
    {
        return $this->hasMany(OrderDetails::class, 'order_id');
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'id', 'order_id');
    }
    public function payment()
    {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }
}
