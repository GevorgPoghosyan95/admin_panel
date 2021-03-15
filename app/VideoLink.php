<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoLink extends Model
{
    protected $fillable = ['name','url','page_id'];

    public function page(){
        return $this->belongsTo(Page::class, 'page_id')->withTimestamps();
    }

}
