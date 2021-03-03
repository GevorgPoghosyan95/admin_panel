<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $fillable = [
        'path'
    ];

    public function folder()
    {
        return $this->hasOne('App\Folder','id','folder_id');
    }
}
