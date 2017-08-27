<?php

namespace App\models;

class Menu extends BaseModel
{
    protected $guarded = [];


    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
