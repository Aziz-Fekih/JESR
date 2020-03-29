<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reponse extends Model
{
    public function Intent()
    {
        return $this->belongsTo('App\Intent');
    }
}
