<?php

namespace App\Models;

use App\Models\Traits\Listable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends BaseModel
{
    use SoftDeletes, Listable;

    const STATUS_PUBLISH = 'publish', STATUS_DRAFT = 'draft';

    public static $allowUpdateFields = ['title', 'detail', 'work_type_id', 'department_id', 'end_time'];
    protected static $allowSearchFields = ['title', 'detail', 'id'];
    protected static $allowGroupFields = ['work_type_id', 'department_id'];
    protected static $allowSortFields = ['created_at', 'work_type_id', 'department_id', 'end_time'];
    public $timestamps = true;
    protected $fillable = ['title', 'detail', 'work_type_id', 'department_id', 'end_time', 'status'];
    protected $hasDefaultValuesFields = ['status'];

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

    public function scopePublishAndDraft($query)
    {
        return $query->where('status', static::STATUS_DRAFT)->orWhere('status', static::STATUS_PUBLISH);
    }

    public function scopeApplyFilter($query, $data)
    {
        $data = $data->only('status', 'only_trashed', 'start_date', 'end_date');
        $query->withSimpleSearch()
            //->withGroup()
            ->withSort()
            ->byStatus(isset($data['status']) ? $data['status'] : null);
        if (isset($data['only_trashed']) && $data['only_trashed']) {
            $query->onlyTrashed();
        }
        if (isset($data['start_date']) && $data['end_date']) {
            $query->range($data['start_date'], $data['end_date']);
        }
        return $query->recent();
    }

    public function scopeByStatus($query, $status)
    {
        if (in_array($status, [static::STATUS_PUBLISH, static::STATUS_DRAFT]))
            return $query->where('status', $status);
        else
            return $query->publishAndDraft();
    }
}
