<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{

    protected $fillable = [
        'quesition_id', 'order', 'introduce' 
    ];

    
    public function quesition()
    {
        return $this->belongsTo('App\Quesition');
    }
}
