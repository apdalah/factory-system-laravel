<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['buyer', 'material', 'amount', 'unit_price', 'paid', 'remain'];
}
