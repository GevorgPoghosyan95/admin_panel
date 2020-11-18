<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Group extends Model
{
    protected $fillable = [
        'name','route'
    ];
    function permissions(){
        return $this->hasMany(Permission::class,'group_id','id');
    }
}
