<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title','body','image','document','lang','path','categoryID','type','menuID','style','galleryType'
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

    public function folders(){
        return $this->belongsToMany(Folder::class,'page_2_folder')->withTimestamps();
    }

    public function videoLinks(){
        return $this->hasMany(VideoLink::class);
    }
}
