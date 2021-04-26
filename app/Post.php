<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title','content','image','lang','video','sub_title'
    ];

    public $timestamps = [
        'created_at','updated_at'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_2_category','post_id','category_id')->withTimestamps();;
    }
}
