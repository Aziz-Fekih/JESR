<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intent extends Model
{
    public function Questions()
    {
        return $this->hasMany('App\Question');
    }
    public function Reponses()
    {
        return $this->hasMany('App\Reponse');
    }
    public function Bot()
    {
        return $this->belongsTo('App\Bot');
    }
}
