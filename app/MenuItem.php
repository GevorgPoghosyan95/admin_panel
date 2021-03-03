<?php

namespace App;

use CodexShaper\Menu\Models\MenuSetting;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    protected $table = 'menu_items';
    //
    protected $fillable = [
        'title', 'slug', 'order', 'parent_id','target',
    ];

    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function child()
    {
        return $this->hasMany(self::class, 'parent_id')->select('menu_items.id as id','menu_items.title','parent_id','pages.path as path','order')->orderBy('order', 'asc');
    }

    // recursive, loads all descendants
    public function children()
    {
        return $this->child()->with('children')->leftJoin('pages','pages.id','=','menu_items.page_id');
    }

    public function settings()
    {
        return $this->hasMany(MenuSetting::class, 'menu_id');
    }

    public function parentMenu()
    {
        return $this->hasone('App\Menu', 'id', 'menu_id');
    }
}
