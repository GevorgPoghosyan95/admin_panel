<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title','body','image','document','lang','path'
    ];

    public function menuItem(){
        return $this->hasOne(MenuItem::class);
    }
}
