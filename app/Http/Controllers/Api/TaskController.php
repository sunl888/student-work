<?php

namespace App\Http\Controllers\Api;

use App\Events\AuditedTask;
use App\Events\TaskSaved;
use App\Http\Requests\AllotTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\SubmitTaskRequest;
use App\Http\Requests\TaskScoreRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
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

    /**
     * 创建任务
     * @param CreateTaskRequest $taskRequest
     * @return \Dingo\Api\Http\Response
     */
    public function createTask(CreateTaskRequest $taskRequest)
    {
        if ($this->allowCreateTask()) {
            event(new TaskSaved($this->taskRepository->createTask($taskRequest->all())));
        }
        return $this->response->noContent();
    }

    /**
     * 任务审核
     * @param $taskId
     */
    public function auditTask($taskId)
    {
        $data['status'] = 'publish';
        if ($this->allowAuditTask()) {
            if ($this->taskRepository->updateTask($data, $taskId)) {
                event(new AuditedTask($taskId));
            }
        }
    }

    /**
     * 修改任务
     * @param $taskId
     * @param UpdateTaskRequest $request
     */
    public function updateTask(UpdateTaskRequest $request, $taskId)
    {
        if ($this->allowUpdateTask()) {
            $this->taskRepository->updateTask($request->only(Task::$allowUpdateFields), $taskId);
        }
    }

    /**
     * 软删除任务
     * @param $taskId
     */
    public function deleteTask($taskId)
    {
        if ($this->allowDeleteTask()) {
            if ($taskId != null) {
                $this->taskRepository->deleteTask($taskId);
            }
        }
        return $this->response->noContent();
    }

    /**
     * 恢复被软删除的任务
     * @param $taskId
     */
    public function restoreTask($taskId)
    {
        if ($this->allowRestoreTask()) {
            if ($taskId != null) {
                $this->taskRepository->restoreTask($taskId);
            }
        }
        return $this->response->noContent();
    }

    /**
     * 分配任务（指派责任人）
     * 因为只有各二级学院有权利对任务分配责任人，所以这里的学院id直接填当前用户的学院id
     * @param AllotTaskRequest $allotTaskRequest
     * @return \Dingo\Api\Http\Response
     */
    public function allotTask(AllotTaskRequest $allotTaskRequest)
    {
        if ($this->allowAllotTask()) {
            $allotTaskRequest->offsetSet('college_id', Auth::user()->college_id);
            app(TaskProgressRepository::class)->allotTask($allotTaskRequest);
        }
        return $this->response->noContent();
    }


    /**
     * 完成任务
     * @param $taskId  任务id
     * @param null $college_id 学院id
     * @return \Dingo\Api\Http\Response
     */
    public function submitTask($taskId, SubmitTaskRequest $request)
    {
        if ($this->allowSubmitTask()) {
            $request->offsetSet('college_id', Auth::user()->college_id);
            $request->offsetSet('status', Carbon::now());
            $request->offsetSet('task_id', $taskId);
            app(TaskProgressRepository::class)->submitTask($request->all());
        }
        return $this->response->noContent();
    }

    /**
     * // 判断指定的任务是否过了截止日期
     * @param $taskId
     */
    public function isDelay($taskId){
        return $this->response()->array(['isDelay'=>app(TaskRepository::class)->isDelay($taskId)]);
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
            $request->offsetSet('task_id', $taskId);
            app(TaskProgressRepository::class)->submitTask($request->all());
        }
        return $this->response->noContent();
    }


    public function tasks($offset = 0)
    {
        return $this->response->collection($this->taskRepository->lists($offset,config('app.default_per_page')), new TaskTransformer());
    }

    public function getTaskProcess()
    {

    }
}
