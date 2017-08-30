<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Models\Task;
use App\Repositories\DepartmentRepository;
use App\Repositories\WorkTypeRepository;
use Carbon\Carbon;
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
            'work_type' => app(WorkTypeRepository::class)->find($task->work_type_id)['title'],
            'department_id' => $task->department_id,
            'department' => app(DepartmentRepository::class)->find($task->department_id)['title'],
            'created_at' => $task->created_at->toDateString(),
            'end_time' => Carbon::parse($task->end_time)->toDateString(),
            'status' => $task->status
        ];
    }
}