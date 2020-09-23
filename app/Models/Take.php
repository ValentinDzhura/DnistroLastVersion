<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\Models\Arrival;

class Take extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'documents',
        'health',
        'dishes',
        'meal',
        'equipment',
        'defence',
        'arrival_id'
    ];

    public function tour(){

        return $this->belongsTo('App\Models\Arrival');

    }
}
