<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name'
    ];

    public $timestamps = [
        'created_at','updated_at'
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_2_category','category_id','post_id');
    }

}
