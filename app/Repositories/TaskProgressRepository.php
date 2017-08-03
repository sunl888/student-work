<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

class TaskProgressRepository extends Repository
{
    public function model()
    {
        return 'App\Models\TaskProgress';
    }

    /*public function allotTask(array $data, array $conditions)
    {
        if ($this->hasRecord($conditions) != null) {
            return $this->update($data, $conditions);
        }
    }*/

    public function submitTask(array $data, $conditions)
    {
        if ($this->hasRecord($conditions) != null) {
            return $this->update($data, $conditions);
        }
    }

    /*public function hasTaskProgress(array $conditions)
    {
        if ($conditions != null) {
            return app(TaskProgress::class)->where($conditions)->first();
        }
    }*/
}