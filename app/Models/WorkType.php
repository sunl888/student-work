<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class WorkType extends BaseModel
{
    use SoftDeletes;

    protected $guarded = [];

}
