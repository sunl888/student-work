<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;


class TaskRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Task';
    }

    public function createTask(array $data){
        if( !$this->hasRecord(['title' => $data['title']])){
            return $this->create($data);
        }
    }
    /*public function getTasksByTime($startTime, $endTime){
        return Task::whereBetween('created_at', [$startTime,$endTime])->get();
    }*/
}