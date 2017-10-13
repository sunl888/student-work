<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Models\TaskProgress;
use App\Repositories\AssessRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\WorkTypeRepository;
use Carbon\Carbon;

class TaskOfTeacherTransformer extends Transformer
{
    public function transform(TaskProgress $progress)
    {
        return [
            'id' => $progress->id,
            'task_id' => $progress->task->id,
            'title' => $progress->task->title,
            'detail' => $progress->task->detail,
            'college_id' => $progress->college_id,
            'user_id' => $progress->user_id,
            'user' => get_lead_official($progress->user_id),
            'work_type' => app(WorkTypeRepository::class)->find($progress->task->work_type_id)['title'],
            'department' => app(DepartmentRepository::class)->find($progress->task->department_id)['title'],
            'assess' => !empty($progress->assess_id) ? app(AssessRepository::class)->find($progress->assess_id)['title'] : null,
            'created_at' => $progress->task->created_at->toDateString(),
            'end_time' => Carbon::parse($progress->task->end_time)->toDateString(),
            //完成状态
            'finished_at' => $progress->status,
            //完成质量
            'quality' => $progress->quality,
            //备注
            'remark' => $progress->remark,
            //推迟理由
            'delay' => $progress->delay,
        ];
    }

}