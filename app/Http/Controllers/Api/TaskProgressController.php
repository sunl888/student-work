<?php

namespace App\Http\Controllers\Api;

use App\Repositories\TaskProgressRepository;
use App\Transformers\TaskProgressTransformer;

class TaskProgressController extends BaseController
{
    //显示任务详情
    public function show($taskId){
        return $this->response->collection(app(TaskProgressRepository::class)->show($taskId), new TaskProgressTransformer());
    }
}
