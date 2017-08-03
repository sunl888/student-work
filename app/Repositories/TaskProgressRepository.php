<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Http\Requests\AllotTaskRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskProgressRepository extends Repository
{
    public function model()
    {
        return 'App\Models\TaskProgress';
    }

    public function createTaskProgress(array $data)
    {
        return $this->model->insert($data);
    }

    public function allotTask($data)
    {
        if($data instanceof AllotTaskRequest){
            $data = $data->toArray();
        }
        $affectRows = $this->update($data, ['task_id' => $data['task_id'], 'college_id' => $data['college_id']]);
        if ($affectRows <=0){
            throw new ModelNotFoundException('添加责任人失败，数据可能已被删除');
        }
    }


    public function submitTask(array $data, $conditions)
    {
        if ($this->hasRecord($conditions) != null) {
            return $this->update($data, $conditions);
        }
    }

    public function deleteTask($taskId)
    {
        if (($tasks = $this->hasRecord(['task_id' => $taskId])) != null) {
            return $tasks->delete();
        }
    }
}