<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Models\Department;
use App\Models\Task;
use App\Models\WorkType;
use League\Fractal\TransformerAbstract;

class TaskTransformer extends TransformerAbstract
{
    public function transform(Task $task)
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'detail' => $task->detail,
            'work_type_id' => $task->work_type_id,
            'work_type' => app(WorkType::class)->find($task->work_type_id, ['title']),
            'department_id' => $task->department_id,
            'department' => app(Department::class)->find($task->department_id, ['name']),
            'created_at' => $task->created_at->toDateTimeString(),
            'end_time' => $task->end_time->toDateTimeString(),
        ];
    }
}