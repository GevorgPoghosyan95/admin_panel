<?php

namespace App\Ekeng;

use App\Group;

class Permission extends \Spatie\Permission\Models\Permission {
    public function groups()
    {
        return $this->belongsTo(Group::class, 'group_id', 'id');
    }
}
