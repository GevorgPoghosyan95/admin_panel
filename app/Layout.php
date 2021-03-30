<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{
    protected $fillable = [
        'name','menu_id','body','image','lang','bottom_content'
    ];

    function menu(){
        return $this->hasOne('App\Menu','id','menu_id');
    }
}
