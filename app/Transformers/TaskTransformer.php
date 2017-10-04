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
use Illuminate\Validation\ValidationException;

class TaskTransformer extends Transformer
{
    protected $availableIncludes = ['task_progresses'];

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

    public function includeTaskProgresses(Task $task)
    {
        $college = $this->validated();
        $task_progress = $task->task_progresses();
        if (!($college['college'] == null && $this->allowSearchTaskDetail())) {
            $task_progress = $task_progress->where(['college_id' => $college]);
        }

        if (is_null($task_progress)) {
            return $this->null();
        } else {
            return $this->collection($task_progress->get(), new TaskProgressTransformer());
        }
    }

    public function validated()
    {
        $college = request()->only('college');

        $validate = \Validator::make($college, [
            'college' => 'nullable|exists:colleges,id'
        ], [
            'college.exists' => '学院id有误.'
        ]);
        if ($validate->fails()) {
            throw new ValidationException($validate);
        }
        return $college;
    }
}