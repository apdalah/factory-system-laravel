<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaysCar extends Model
{
    protected $fillable = ['driver', 'day', 'description', 'price', 'paid', 'remain'];
}
