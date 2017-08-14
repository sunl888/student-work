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
        try{
            $task = $this->model->findOrFail($taskId);
        }catch (ModelNotFoundException $e){
            throw new ModelNotFoundException('没有找到该任务');
        }
        $task->task_progresses()->delete();
        return $task->delete();
    }

    public function restoreTask($taskId)
    {
        try{
            $task = $this->model->onlyTrashed()->findOrFail($taskId);
        }catch (ModelNotFoundException $e){
            throw new ModelNotFoundException('没有找到该任务');
        }
        $task->task_progresses()->restore();
        return $task->restore();
    }

    public function forceDeleteTask($taskId)
    {
        try{
            $task = $this->model->onlyTrashed()->findOrFail($taskId);
        }catch (ModelNotFoundException $e){
            throw new ModelNotFoundException('没有找到该任务');
        }
        $task->task_progresses()->forceDelete();
        return $task->forceDelete();
    }

    public function isDelay($taskId){
        return $this->model->findOrFail($taskId)->isDelay();
    }

    public function lists($offset, $limit){
        return $this->model->forPage($offset,$limit)->recent()->get();
    }

    public function getTask($taskId){
        return $this->model->find($taskId);
    }

    public function getTrashed($offset, $limit){
        return $this->model->onlyTrashed()->forPage($offset,$limit)->recent()->get();
    }

    public function reStore($id){
        return $this->model->withTrashed()
            ->where('id',$id)
            ->restore();
    }

}