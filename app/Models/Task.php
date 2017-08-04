<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends BaseModel
{
    use SoftDeletes;

    protected $fillable = ['title', 'detail', 'work_type_id', 'department_id', 'end_time','status'];

    protected $hasDefaultValuesFields = ['status'];

    public static $allowUpdateFields = ['title', 'detail', 'work_type_id', 'department_id', 'end_time'];

    public $timestamps = true;

    /**
     * 一个任务可以有多个执行者
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function task_progresses()
    {
        return $this->hasMany(TaskProgress::class);
    }

    public function isPublish()
    {
        return $this->status == 'publish';
    }

    public function isDraft()
    {
        return $this->type == 'draft';
    }

    public function scopePublish($query)
    {
        return $query->where('status', 'publish');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * 延迟提交
     * rule: 当前日期是否大于任务的截止日期 ?: false
     * @return bool
     */
    public function isDelay(){
        $end_time = Carbon::parse($this->end_time);
        return (Carbon::now()->gt($end_time) );
    }
}
