<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class Menu extends BaseModel
{
    protected $guarded  = [];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
