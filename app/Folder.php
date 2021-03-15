<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $table = 'Folders';
    protected $fillable = [
        'name'
    ];
    public function files()
    {
        return $this->hasMany(Media::class, 'folder_id', 'id');
    }

    public function pages(){
        return $this->belongsToMany(Page::class,'page_2_folder')->withTimestamps();
    }
}
