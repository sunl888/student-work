<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class College extends BaseModel
{
    use SoftDeletes;

    protected $guarded = [];
}
