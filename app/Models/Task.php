<?php

namespace App\Models;


class Task extends BaseModel
{
    protected $fillable = ['title','detail','work_type_id','department_id','end_time'];

    public $timestamps = false;

    /**
     * 一个任务可以有多个执行者
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function task_progresses(){
        return $this->hasMany(TaskProgress::class);
    }

    //public function
}
