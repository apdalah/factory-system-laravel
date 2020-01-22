<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    protected $fillable = ['day', 'category_id', 'amount'];

    public function category()
    {
    	return $this->belongsTo(Category::class);
    }

} // end of production model
