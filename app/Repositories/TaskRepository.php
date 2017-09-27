<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Task;
use App\Models\TaskProgress;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskRepository extends Repository
{
    public function __construct()
    {
        $this->model = app(Task::class);
    }

    public function createTask(array $data)
    {
        if (!$this->hasRecord($data)) {
            return $this->create($data);
        } else {
            throw new ModelNotFoundException('该任务已经存在');
        }
    }

    public function updateTask(array $data, $taskId)
    {
        $conditions = ['status' => 'draft', 'id' => $taskId];
        if ($task = $this->hasRecord($conditions)) {
            return $task->update($data);
        } else {
            throw new ModelNotFoundException('该任务不存在或者任务已发布，不可以修改');
        }
    }

    public function deleteTask($taskId)
    {
        try {
            $task = $this->model->findOrFail($taskId);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('没有找到该任务');
        }
        $task->task_progresses()->delete();
        return $task->delete();
    }

    public function restoreTask($taskId)
    {
        try {
            $task = $this->model->onlyTrashed()->findOrFail($taskId);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('没有找到该任务');
        }
        $task->task_progresses()->restore();
        return $task->restore();
    }

    public function forceDeleteTask($taskId)
    {
        try {
            $task = $this->model->onlyTrashed()->findOrFail($taskId);
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('没有找到该任务');
        }
        $task->task_progresses()->forceDelete();
        return $task->forceDelete();
    }

    public function isDelay($taskId)
    {
        return $this->model->findOrFail($taskId)->isDelay();
    }

    // 获取这个学院的任务列表
    public function tasksByCollege($limit, array $conditions = null)
    {
        $tasks = $this->model->where('status', 'publish')->recent()->paginate($limit);
        foreach ($tasks as &$task) {
            $conditions['task_id'] = $task->id;
            $task['task_progress'] = app(TaskProgress::class)->where($conditions)->first();
        }
        return $tasks;
    }

    public function tasksByTeacher($limit, array $conditions = null)
    {
        $tasks = $this->model->where('status', 'publish')->recent()->paginate($limit);
        foreach ($tasks as &$task) {
            $conditions['task_id'] = $task->id;
            $task['task_progress'] = app(TaskProgress::class)->where($conditions)->first();
        }
        return $tasks;
    }

    public function taskAndPregress($conditions)
    {
        $task = $this->model->where('status', 'publish')->where('id', array_get($conditions, 'task_id'))->first();
        if ($task) {
            $task['task_progress'] = app(TaskProgress::class)->where($conditions)->first();
        } else {
            throw new ModelNotFoundException('该任务不存在');
        }
        return $task;
    }

    public function getTask($taskId)
    {
        return $this->model->find($taskId);
    }

    public function reStore($id)
    {
        return $this->model->withTrashed()
            ->where('id', $id)
            ->restore();
    }

}