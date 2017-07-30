<?php

namespace App\Models;

class TaskProgress extends BaseModel
{
    protected $table = 'task_progresses';
    protected $fillable = ['task_id','college_id','user_id','assess_id','status','quality','remark','remind'];

    public function isFinishedTask()
    {
        return !is_null($this->status);
    }
}
