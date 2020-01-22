<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['material_name', 'supplier', 'amount', 'unit_price', 'paid', 'remain'];
}
