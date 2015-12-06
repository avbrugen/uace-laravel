<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bidders extends Model
{
    public function info()
    {
        $this->hasMany('App\User');
    }
}
