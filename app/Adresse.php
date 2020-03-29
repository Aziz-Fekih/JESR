<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adresse extends Model
{
    protected $fillable = [
        'adresse', 'gouvernorat', 'gouvernorat_id'
    ];

    public function Gouvernorat()
    {
        return $this->belongsTo('App\Gouvernorat');
    }
    public function Users()
    {
        return $this->hasMany('App\User');
    }
    public function Associations()
    {
        return $this->hasMany('App\Association');
    }
    public function Dons()
    {
        return $this->hasMany('App\Don');
    }
}
