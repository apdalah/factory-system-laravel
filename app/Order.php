<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['client_id', 'title', 'status', 'description'];

    public function client()
    {
    	return $this->belongsTo(Client::class);
    }

    public function subOrders()
    {
    	return $this->hasMany(SubOrder::class);
    }
}
