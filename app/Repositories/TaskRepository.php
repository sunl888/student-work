<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;


use App\Models\Task;

class TaskRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Task';
    }

    public function createTask(array $data){
        if( !$this->hasRecord($data)){
            return $this->create($data);
        }
    }

    public function updateTask(array $data, $conditions){
        if( !$this->hasRecord($conditions)){
            return $this->save($data);
        }
    }

    public function deleteTask($taskId){
        $this->model->findOrFail($taskId)->task_progresses()->delete();
        return $this->model->find($taskId)->delete();
    }

    public function restoreTask($taskId){
        $this->model->onlyTrashed()->findOrFail($taskId)->task_progresses()->onlyTrashed()->restore();
        return $this->model->onlyTrashed()->find($taskId)->restore();
    }

    /*public function getTasksByTime($startTime, $endTime){
        return Task::whereBetween('created_at', [$startTime,$endTime])->get();
    }*/
}