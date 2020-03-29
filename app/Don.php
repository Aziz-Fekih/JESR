<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Don extends Model
{  
    protected $fillable = [
        'etat'
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
