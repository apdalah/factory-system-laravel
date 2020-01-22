<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DaysWorker extends Model
{
    protected $fillable = ['worker_id', 'day', 'description', 'price', 'paid', 'remain'];

    public function worker()
    {
    	return $this->belongsTo(Worker::class);
    }
}
