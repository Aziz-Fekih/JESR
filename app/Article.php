<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{    protected $fillable = [
         'nom', 'description'
        ];
    public function User()
    {
        return $this->belongsTo('App\User');
    }
}
