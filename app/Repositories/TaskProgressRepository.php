<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\TaskProgress;

class TaskProgressRepository extends Repository
{
    public function model()
    {
        return 'App\Models\TaskProgress';
    }
    public function allotTask(array $data = null){
        if(!empty($data)){
            if(!TaskProgress::where(['task_id'=>$data['task_id'],'college_id'=>$data['college_id'] ])->first()){
                $this->create($data);
            }
        }
    }

    public function submitTask(array $data, $conditions)
    {
        $this->update($data, $conditions);
    }
}