<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ekeng\Permission;

class Group extends Model
{
    protected $fillable = [
        'name','route'
    ];
    function permissions(){
        return $this->hasMany(Permission::class,'group_id','id');
    }
}
