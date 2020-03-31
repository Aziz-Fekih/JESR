<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Don extends Model
{  
    protected $fillable = [
        'etat', 'user_id'
    ];
    public function Adresse()
    {
        return $this->belongsTo('App\Adresse');
    }
    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
