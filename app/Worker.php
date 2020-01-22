<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    protected $fillable = ['name', 'job'];

    public function daysWorker()
    {
    	return $this->hasMany(DaysWorker::class);
    }
}
