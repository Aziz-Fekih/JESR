<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    public function Conversations()
    {
        return $this->hasMany('App\Conversation');
    }
    public function User()
    {
        return $this->belongsTo('App\User');
    }
    public function Intents()
    {
        return $this->hasMany('App\Intent');
    }
}
