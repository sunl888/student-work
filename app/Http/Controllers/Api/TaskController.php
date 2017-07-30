<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskSaved;
use App\Http\Requests\AllotTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Repositories\TaskProgressRepository;
use App\Repositories\TaskRepository;
use App\Transformers\TaskTransformer;
use Auth;
use Carbon\Carbon;

class TaskController extends BaseController
{
    protected $taskRepository;

    public function __construct(TaskRepository $repository)
    {
        $this->taskRepository = $repository;
    }

    private function allowCreateTask()
    {
        return $this->validatePermission('admin.create_task');
    }

    private function allowAllotTask()
    {
        return $this->validatePermission('admin.add_person_liable');
    }

    private function allowSubmitTask()
    {
        return $this->validatePermission('admin.submit_task');
    }

    public function createTask(CreateTaskRequest $taskRequest)
    {
        if ($this->allowCreateTask()) {
            //save
            $this->taskRepository->create($taskRequest->all());
            event(new TaskSaved($taskRequest));
        }
        return $this->response->noContent();
    }

    public function tasks()
    {
        return $this->response->collection($this->taskRepository->lists(), new TaskTransformer());
    }

    /**
     * 分配任务（指派责任人）
     * @param AllotTaskRequest $allotTaskRequest
     * @return \Dingo\Api\Http\Response
     */
    public function allotTask(AllotTaskRequest $allotTaskRequest)
    {
        if ($this->allowAllotTask()) {
            $allotTask = $allotTaskRequest->all();
            $allotTask['college_id'] = Auth::user()->college_id;
            app(TaskProgressRepository::class)->allotTask($allotTask);
        }
        return $this->response->noContent();
    }


    /**
     * @param $taskId  任务id
     * @param null $college_id 学院id
     * @return \Dingo\Api\Http\Response
     */
    public function submitTask($taskId)
    {
        if ($this->allowSubmitTask()) {
            $college_id = Auth::user()->college_id;
            $data['status'] = Carbon::now();
            app(TaskProgressRepository::class)->submitTask($data, ['task_id' => $taskId, 'college_id' => $college_id]);
        }
        return $this->response->noContent();
    }

}
