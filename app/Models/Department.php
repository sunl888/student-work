<?php

namespace App\Models;

use App\Models\Traits\Cachable;
use Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends BaseModel
{
    use SoftDeletes {
        restore as private restoreA;
    }
    use Cachable {
        restore as private restoreB;
    }

    protected $guarded = [];

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function clearCache()
    {
        Cache::forget('departments');
    }
}
