<?php

namespace App\Models;

use App\Models\Traits\Cachable;
use Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends BaseModel
{
    protected $fillable = ['title'];

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

    public function user()
    {
        return $this->belongsTo(User::class, 'college_id', 'id');
    }

    public function clearCache()
    {
        Cache::forget('colleges');
    }

}
