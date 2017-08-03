<?php

namespace App\Http\Controllers\Api;

use App\Repositories\TaskProgressRepository;
use App\Transformers\TaskProgressTransformer;

class TaskProgressController extends BaseController
{
    public function show($taskId){
        return $this->response->collection(app(TaskProgressRepository::class)->show($taskId), new TaskProgressTransformer());
    }
}
