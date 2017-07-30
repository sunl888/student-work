<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskSaved;
use App\Http\Requests\CreateTaskRequest;
use App\Repositories\TaskRepository;
use App\Transformers\TaskTransformer;

class TaskController extends BaseController
{
    protected $taskRepository;

    public function __construct(TaskRepository $repository)
    {
        $this->taskRepository = $repository;
    }

    public function allowCreateTask(){
        return $this->validatePermission('admin.create_task');
    }
    public function createTask(CreateTaskRequest $taskRequest){
        if($this->allowCreateTask()){
            //save
            $this->repository->create($taskRequest->all());
            event(new TaskSaved($taskRequest));
        }
        return $this->response->noContent();
    }

    public function tasks(){
        //dd($this->taskRepository->lists());
        return $this->response->collection($this->taskRepository->lists(), new TaskTransformer());
    }
}
