<?php

namespace App\models;

use App\Models\Traits\Cachable;
use Cache;

class Menu extends BaseModel
{
    use Cachable;

    protected $guarded = [];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function clearCache()
    {
        Cache::forget('menus');
    }
}
