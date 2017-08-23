<?php

namespace App\Http\Controllers\Api;

use App\Events\AuditedTask;
use App\Events\TaskAlloted;
use App\Events\TaskSaved;
use App\Http\Requests\AllotTaskRequest;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\SubmitTaskRequest;
use App\Http\Requests\TaskScoreRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\TaskProgress;
use App\Models\User;
use App\Notifications\NewTask;
use App\Notifications\TaskRemind;
use App\Repositories\TaskProgressRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Transformers\TaskAndProgressTransformer;
use App\Transformers\TaskTransformer;
use Auth;
use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Notification;

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
            $task = $this->taskRepository->createTask($taskRequest->all());
            event(new TaskSaved($task));
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
     * 任务取消审核
     * @param $taskId
     */
    public function cancelAuditTask($taskId)
    {
        $data['status'] = 'draft';
        if ($this->allowAuditTask()) {
            $this->taskRepository->update($data, ['id'=>$taskId]);
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
            $this->taskRepository->updateTask($request->all(), $taskId);
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
     * 强制删除
     * @param $taskId
     * @return \Dingo\Api\Http\Response
     */
    public function forceDeleteTask($taskId)
    {
        if ($this->guard()->user()->isSuperAdmin()) {
            if ($taskId != null) {
                $this->taskRepository->forceDeleteTask($taskId);
            }
        }
        return $this->response->noContent();
    }

    /**
     * 分配任务（指派责任人）
     * 因为只有各二级学院有权利对任务分配责任人，所以这里的学院id直接填当前用户的学院id
     * @param AllotTaskRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function allotTask(AllotTaskRequest $request)
    {
        if ($this->allowAllotTask()) {
            $college_id = $this->guard()->user()->college_id;
            $request->offsetSet('college_id', $college_id);
            app(TaskProgressRepository::class)->allotTask($request);
            event(new TaskAlloted($request));
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
    public function isDelay($taskId)
    {
        return $this->response()->array(['isDelay' => app(TaskRepository::class)->isDelay($taskId)]);
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

    public function tasks(Request $request)
    {
        if(($status = $request->get('status')) != null){
            return $this->response()->paginator($this->taskRepository->lists($this->perPage(),['status'=>$status]), new TaskTransformer());
        }
        return $this->response()->paginator($this->taskRepository->lists($this->perPage()), new TaskTransformer());
    }

    /**
     * 获取某个学院的任务列表
     * @param null $collegeId
     */
    public function getTasksByCollege($collegeId = null){
        if ($collegeId == null){
            $condisions['college_id'] = $this->guard()->user()->college_id;
        }else{
            $condisions['college_id'] = $collegeId;
        }
        return $this->response()->paginator($this->taskRepository->tasksByCollege($this->perPage(),$condisions), new TaskAndProgressTransformer());
    }

    public function task($taskId)
    {
        return $this->response->item($this->taskRepository->getTask($taskId), new TaskTransformer());
    }

    public function getTrashed()
    {
        return $this->response()->paginator($this->taskRepository->getTrashed($this->perPage()), new TaskTransformer());
    }

    public function reStore($id){
        return $this->taskRepository->reStore($id);
    }

    /**
     * 催交
     * @param Task $task
     * @param $collegeId
     * @throws AuthorizationException
     */
    public function remind(Task $task, $collegeId)
    {
        if ($this->guard()->user()->hasRole('super_admin')){
            //判断有没有责任人，如果没有则只向该学院发送提醒通知
            //判断责任人是不是所有人(all)，如果是则向该学院所有人发送通知
            $task_progress = $task->task_progresses()->where(['college_id'=>$collegeId])->first();
            $users = new Collection();
            if (isset($task_progress->user_id)){
                //全体人员
                if($task_progress->user_id == TaskProgress::$personnelSign){
                    $users = app(UserRepository::class)->usersWithCollege($collegeId,true);
                }else{
                    $users = $users->merge(app(UserRepository::class)->find(['id',$task_progress->user_id]));
                }
            }
            $users = $users->merge(app(UserRepository::class)->usersWithRoles(['college'])->where('college_id',$collegeId)->all());
            //发送任务提醒通知
            Notification::send($users, new TaskRemind($users, $task));
        }else{
            throw new AuthorizationException("没有操作权限");
        }
    }

}
