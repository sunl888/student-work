<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Task;
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
        }else{
            throw new ModelNotFoundException('该任务已经存在');
        }
    }

    public function updateTask(array $data, $taskId)
    {
        $conditions = ['status' => 'draft', 'id' => $taskId];
        if ($task = $this->hasRecord($conditions)) {
            return $task->update($data);
        }else{
            throw new ModelNotFoundException('该任务不存在或者任务已发布，不可以修改');
        }
    }

    public function deleteTask($taskId)
    {
        $this->model->findOrFail($taskId)->task_progresses()->delete();
        return $this->model->find($taskId)->delete();
    }

    public function restoreTask($taskId)
    {
        $this->model->onlyTrashed()->findOrFail($taskId)->task_progresses()->onlyTrashed()->restore();
        return $this->model->onlyTrashed()->find($taskId)->restore();
    }

    public function isDelay($taskId){
        return $this->model->findOrFail($taskId)->isDelay();
    }

    public function lists($offset,$limit){
        return $this->model->forPage($offset,$limit)->recent()->get();
    }


    /*public function getTasksByTime($startTime, $endTime){
        return Task::whereBetween('created_at', [$startTime,$endTime])->get();
    }*/
}