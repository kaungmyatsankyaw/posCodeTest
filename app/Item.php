<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected  $table='items';
    protected $fillable=['name','price','is_set'];

    public function set(){
        return $this->belongsTo('App\Set');
    }

}
