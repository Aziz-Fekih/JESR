<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    public function Bot()
    {
        return $this->belongsTo('App\Bot');
    }
}
