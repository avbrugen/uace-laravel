<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    public function images()
    {
        return $this->hasMany('App\Uploads');
    }

    public function curuser()
    {
        return $this->hasMany('App\User', 'id', 'user');
    }

    public function bidders()
    {
        return $this->hasMany('App\Bidders');
    }
}
