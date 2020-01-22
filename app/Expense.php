<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['supplier', 'description', 'price', 'paid', 'remain'];
}
