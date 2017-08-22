<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Models\Assess;
use App\Models\Department;
use App\Models\Task;
use App\Models\TaskProgress;
use App\Models\User;
use App\Models\WorkType;
use Carbon\Carbon;
use League\Fractal\TransformerAbstract;

class TaskAndProgressTransformer extends Transformer
{
    public function transform(Task $task)
    {
        return [
            'id' => $task->id,
            'title' => $task->title,
            'detail' => $task->detail,
            //'work_type_id' => $task->work_type_id,
            'work_type' => app(WorkType::class)->find($task->work_type_id)['title'],
            //'department_id' => $task->department_id,
            'department' => app(Department::class)->find($task->department_id)['title'],
            'created_at' => $task->created_at->toDateString(),
            'end_time' => Carbon::parse($task->end_time)->toDateString(),
            //'status' =>$task->status,
            //完成状态
            'finished_at' =>$task->task_progress->status,
            //责任人
            'user' => $task->task_progress->user_id == TaskProgress::$personnelSign?'全体人员': app(User::class)->find(1)['name'],
            //等级
            'assess' =>!empty($task->task_progress->assess_id)?app(Assess::class)->find($task->task_progress->assess_id)['title']:null,
            //完成质量
            'quality' =>$task->task_progress->quality,
            //备注
            'remark' =>$task->task_progress->remark,
            //推迟理由
            'delay' =>$task->task_progress->delay,
            ];
    }

}