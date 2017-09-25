<?php

namespace App\Models;

use App\Models\Traits\Listable;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskProgress extends BaseModel
{
    use SoftDeletes, Listable;

    /**
     * 全体人员的标志
     * @var string
     */
    public static $personnelSign = 'all';

    protected $table = 'task_progresses';
    protected $fillable = ['task_id', 'college_id', 'user_id', 'assess_id', 'status', 'delay', 'quality', 'remark', 'remind'];

    public function isFinishedTask()
    {
        return !is_null($this->status);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /*public function getUserIdAttribute($key)
    {
        return ucfirst($key);
    }*/

    public function scopeAsUsers($query, $user)
    {
        //todo 这里贼恶心
        return $query->where('user_id', static::$personnelSign)
            ->orWhere('user_id', $user)
            ->orWhere('user_id', 'like', '%' . ",$user," . '%')
            ->orWhere('user_id', 'like', '%' . "$user," . '%')
            ->orWhere('user_id', 'like', '%' . ",$user" . '%');
    }
}
