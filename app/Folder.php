<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    protected $table = 'Folders';
    protected $fillable = [
        'name'
    ];
    public function picture()
    {
        return $this->hasMany(Media::class, 'folder_id', 'id');
    }
}
