<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gouvernorat extends Model
{
    // public function Municipalites()
    // {
    //     return $this->hasMany('App\Municipalite');
    // }

    public function Adresses()
    {
        return $this->hasMany('App\Adresse');
    }
    public function Dons()
    {
        return $this->hasMany('App\Don');
    } 
}
