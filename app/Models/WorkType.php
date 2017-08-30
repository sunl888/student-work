<?php

namespace App\Models;

use App\Models\Traits\Cachable;
use Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkType extends BaseModel
{
    use SoftDeletes {
        restore as private restoreA;
    }
    use Cachable {
        restore as private restoreB;
    }

    protected $fillable = ['title'];

    /**
     * 由于 Cachable 和 SoftDeletes 两个 trait 都包含 restore 方法，所以当我们对 Model 使用软删除的时候同时集成 Cachable 的时候就会导致冲突。
     * 解决方法: 引用两个 trait 时为 restore 方法设置别名，然后重写一个 restore 方法，分别调用两个 restore 方法。
     */
    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function clearCache()
    {
        Cache::forget('work_types');
    }
}
