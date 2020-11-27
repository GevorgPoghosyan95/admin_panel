<?php

namespace App;

use CodexShaper\Menu\Models\MenuSetting;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';
    //
    protected $fillable = [
        'title', 'slug', 'order', 'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(self::class, 'parent_id')->select('id','title','parent_id','order')->orderBy('order', 'asc');
    }

    // recursive, loads all descendants
    public function children()
    {
        return $this->child()->with('children');
    }

    public function settings()
    {
        return $this->hasMany(MenuSetting::class, 'menu_id');
    }
}
