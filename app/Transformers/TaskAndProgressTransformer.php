<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Models\Task;
use App\Repositories\AssessRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\WorkTypeRepository;
use Carbon\Carbon;

class TaskAndProgressTransformer extends Transformer
{
    public function transform(Task $task)
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'detail' => $task->detail,
            'work_type' => app(WorkTypeRepository::class)->find($task->work_type_id)['title'],
            'department' => app(DepartmentRepository::class)->find($task->department_id)['title'],
            'created_at' => $task->created_at->toDateString(),
            'end_time' => Carbon::parse($task->end_time)->toDateString(),
            //完成状态
            'finished_at' => $task->task_progress->status,
            //责任人
            'user' => isset($task->task_progress->user_id) ? get_lead_official($task->task_progress->user_id) : null,
            //等级
            'assess' => !empty($task->task_progress->assess_id) ? app(AssessRepository::class)->find($task->task_progress->assess_id)['title'] : null,
            //完成质量
            'quality' => $task->task_progress->quality,
            //备注
            'remark' => $task->task_progress->remark,
            //推迟理由
            'delay' => $task->task_progress->delay,
        ];
    }

}