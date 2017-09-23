<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\AllotTaskRequest;
use App\Models\College;
use App\Models\Task;
use App\Repositories\TaskProgressRepository;
use App\Transformers\TaskProgressTransformer;
use App\Events\TaskAlloted;

class TaskProgressController extends BaseController
{
    //显示任务详情
    public function show($taskId)
    {
        return $this->response->collection(app(TaskProgressRepository::class)->show(['task_id' => $taskId]), new TaskProgressTransformer());
    }
    /**
     * 分配任务（指派责任人）
     * @param AllotTaskRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function allotTask(Task $task, College $college, AllotTaskRequest $request)
    {
        dd($request->all());
        if ($this->allowAllotTask()) {
            $request->offsetSet('college_id', $college->id);
            $request->offsetSet('task_id', $task->id);
            app(TaskProgressRepository::class)->allotTask($request);
            event(new TaskAlloted($request));
        }
        return $this->response->noContent();
    }

}
