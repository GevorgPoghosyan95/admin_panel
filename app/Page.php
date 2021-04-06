<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title','body','image','document','lang',
        'path','categoryID','type','menuID','style',
        'galleryType','color','bg_color','carouselType','mainCarouselID','car_template','carouselNewsCategory'
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

    public function mainCarousel(){
        return $this->hasOne(Folder::class,'id','mainCarouselID');
    }

    public function videoLinks(){
        return $this->hasMany(VideoLink::class);
    }
}
