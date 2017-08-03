<?php

namespace App\Http\Controllers\Api;

use App\Events\TaskSaved;
use App\Http\Requests\AllotTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\TaskScoreRequest;
use App\Repositories\TaskProgressRepository;
use App\Repositories\TaskRepository;
use Auth;
use Carbon\Carbon;

class TaskController extends BaseController
{
    protected $taskRepository;

    public function __construct(TaskRepository $repository)
    {
        $this->taskRepository = $repository;
    }

    /**
     * 创建任务
     * @param CreateTaskRequest $taskRequest
     * @return \Dingo\Api\Http\Response
     */
    public function createTask(CreateTaskRequest $taskRequest)
    {
        //if (!$this->guard()->user()->isSuperAdmin())
        if ($this->allowCreateTask()) {
            $task = $this->taskRepository->createTask($taskRequest->all());
            event(new TaskSaved($task));
        }
        return $this->response->noContent();
    }

    public function deleteTask($taskId){
        if($taskId != null){
            $this->taskRepository->deleteTask($taskId);
        }
    }
    public function restoreTask($taskId){
        if($taskId != null){
            $this->taskRepository->restoreTask($taskId);
        }
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
            $college_id = Auth::user()->college_id;
            app(TaskProgressRepository::class)->allotTask($allotTask, ['task_id' => $allotTask['task_id'], 'college_id' => $college_id]);
        }
        return $this->response->noContent();
    }


    /**
     * 完成任务
     * @param $taskId  任务id
     * @param null $college_id 学院id
     * @return \Dingo\Api\Http\Response
     */
    public function submitTask($taskId)
    {
        if ($this->allowCreateTask()) {
            $college_id = Auth::user()->college_id;
            $data['status'] = Carbon::now();
            app(TaskProgressRepository::class)->submitTask($data, ['task_id' => $taskId, 'college_id' => $college_id]);
        }
        return $this->response->noContent();
    }

    /**
     * 任务评分
     * @param $taskId
     * @param TaskScoreRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function taskScore($taskId, TaskScoreRequest $request)
    {
        if ($this->allowScore()) {
            $data = $request->all();
            app(TaskProgressRepository::class)->submitTask($data, ['task_id' => $taskId, 'college_id' => $data['college_id']]);
        }
        return $this->response->noContent();
    }

    private function allowCreateTask()
    {
        return $this->validatePermission('admin.create_task');
    }
    private function allowDeleteTask()
    {
        return $this->validatePermission('admin.delete_task');
    }
    private function allowRestoreTask()
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

    private function allowScore()
    {
        return $this->validatePermission('admin.quality_assessment');
    }

    /*public function tasks()
    {
        return $this->response->collection($this->taskRepository->lists(), new TaskTransformer());
    }*/
    public function showTaskProgress($taskId)
    {

    }
}
