<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'name','slug','url','order','created_at','updated_at'
    ];
}
