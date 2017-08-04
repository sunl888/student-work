<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Assess extends BaseModel
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = 'assess';
}
