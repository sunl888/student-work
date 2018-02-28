<?php

namespace App\Models;

use App\Models\Traits\Cachable;
use Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends BaseModel
{
    protected $fillable = ['title', 'is_show'];

    use SoftDeletes {
        restore as private restoreA;
    }
    use Cachable {
        restore as private restoreB;
    }

    protected $guarded = [];

    /**
     * 模型的「启动」方法
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        // 全局作用域
        //User::withoutGlobalScopes()->get();
        static::addGlobalScope('isShow', function (Builder $builder) {
            $builder->where('is_show', true);
        });
    }

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
