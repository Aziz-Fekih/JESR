<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public function flow()
    {
        return $this->belongsTo('App\Flow');
    }
}
