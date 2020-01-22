<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name'];

    public function subOrder()
    {
    	return $this->hasMany(SubOrder::class);
    }
}
