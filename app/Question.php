<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function Intent()
    {
        return $this->belongsTo('App\Intent');
    }
}
