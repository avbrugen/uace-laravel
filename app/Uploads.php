<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Uploads extends Model
{
    protected $table = 'uploads';
    protected $fillable = array('auction_id');

    public function auctions()
    {
        return $this->belongsToMany('App\Auction');
    }

}
