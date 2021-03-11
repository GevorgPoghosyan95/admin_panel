<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title','body','image','document','lang','path','categoryID','type','menuID','style'
    ];

    public function menuItem(){
        return $this->hasOne(MenuItem::class);
    }

    public function leftMenu(){
        return $this->belongsTo(Menu::class,'menuID');
    }

    public function categories(){
        return $this->belongsTo(Category::class,'categoryID');
    }
}
