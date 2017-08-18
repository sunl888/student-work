<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class TaskProgress extends BaseModel
{
    use SoftDeletes;

    protected $table = 'task_progresses';

    protected $fillable = ['task_id', 'college_id', 'user_id', 'assess_id', 'status', 'delay', 'quality', 'remark', 'remind'];

    /**
     * 全体人员的标志
     * @var string
     */
    public static $personnelSign = 'all';

    public function isFinishedTask()
    {
        return !is_null($this->status);
    }

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
