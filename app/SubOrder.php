<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubOrder extends Model
{
    protected $fillable = ['category_id', 'order_id', 'amount', 'unit_price', 'paid', 'remain'];

    public function order()
    {
    	return $this->belongsTo(Order::class);
    }

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }
}
