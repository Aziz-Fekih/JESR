<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipalite extends Model
{
    public function Gouvernorat()
    {
        return $this->belongsTo('App\Gouvernorat');
    }
    public function Adresses()
    {
        return $this->hasMany('App\Adresse');
    }
    public function Dons()
    {
        return $this->hasMany('App\Don');
    }
}
