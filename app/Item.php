<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable=['name','price'];

    public function set(){
        return $this->belongsTo('App\Set');
    }

}
