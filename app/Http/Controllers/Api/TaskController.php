<?php

namespace App\Http\Controllers\Api;

use App\Events\AuditedTask;
use App\Events\TaskSaved;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\SubmitTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\College;
use App\Models\Remind;
use App\Models\Task;
use App\Models\TaskProgress;
use App\Models\User;
use App\Notifications\TaskRemind;
use App\Repositories\AssessRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\TaskProgressRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkTypeRepository;
use App\Transformers\TaskAndProgressTransformer;
use App\Transformers\TaskTransformer;
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
            $this->taskRepository->update($data, ['id' => $taskId]);
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
     * @param Task $task
     * @param College $college
     * @param SubmitTaskRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function submitTask(Task $task, College $college, SubmitTaskRequest $request)
    {
        if ($this->allowSubmitTask()) {
            $request->offsetSet('task_id', $task->id);
            $request->offsetSet('college_id', $college->id);
            app(TaskProgressRepository::class)->submitTask($request->all());
        }
        return $this->response->noContent();
    }

    /**
     * 根据条件显示任务列表
     * ?only_trashed=0|1  ?status=draft|publish
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function tasks(Request $request)
    {
        $tasks = Task::applyFilter($request)
            ->paginate($this->perPage());
        return $this->response()->paginator($tasks, new TaskTransformer());
    }

    /**
     * 获取某个学院的任务列表
     * @param null $collegeId
     */
    public function getTasksByCollege($college = null)
    {

        if ($college instanceof College) {
            $condisions['college_id'] = $college;
        } else {
            $condisions['college_id'] = $this->guard()->user()->college_id;
        }
        return $this->response()->paginator($this->taskRepository->tasksByCollege($this->perPage(), $condisions), new TaskAndProgressTransformer());
    }

    public function getTasksByTeacher()
    {
        $tasks = app(TaskProgress::class)->asUsers($this->guard()->id())->get()->load('task');
        $res = new Collection();
        foreach ($tasks as $task) {
            $tmp = $task->task()->where(['status' => 'publish'])->first();
            $task->user = $this->getLeadOfficial($task);
            $task->work_type = app(WorkTypeRepository::class)->find($tmp->work_type_id)['title'];
            $task->department = app(DepartmentRepository::class)->find($tmp->department_id)['title'];
            $task->assess = !empty($task->assess_id) ? app(AssessRepository::class)->find($task->assess_id)['title'] : null;
            if ($tmp) {
                $res->push($task);
            }
        }
        return $this->response()->array($res->forPage(request('page') ?: 1, $this->perPage())->toArray());
    }

    /**
     * 获取责任人
     * @param $taskProgress
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|string|static|static[]
     */
    public function getLeadOfficial($taskProgress)
    {
        $userIds = explode(',', $taskProgress->user_id);
        if (array_first($userIds) != null) {
            if (strtolower(array_first($userIds)) == TaskProgress::$personnelSign) {
                return '全体人员';
            } elseif (count($userIds) == 1) {
                return User::find(array_first($userIds), ['id', 'name']);
            } elseif (count($userIds) > 1) {
                return User::whereIn('id', $userIds)->get(['id', 'name']);
            }
        } else {
            return null;
        }
    }

    public function task(Task $task)
    {
        return $this->response->item(Task::findOrFail($task->id), new TaskTransformer());
    }

    /*public function getTaskDetail($taskId)
    {
        $conditions = ['task_id' => $taskId, 'college_id' => Auth::guard()->user()->college_id];
        return $this->response()->item($this->taskRepository->taskAndPregress($conditions), new TaskAndProgressTransformer());
    }*/

    /**
     * 恢复任务
     * @param $id
     * @return mixed
     */
    public function reStore($task_id)
    {
        return $this->taskRepository->reStore($task_id);
    }

    /**
     * 催交
     * @param Task $task
     * @param $collegeId
     * @throws AuthorizationException
     */
    public function remind(Task $task, $collegeId)
    {
        if ($this->guard()->user()->hasRole('super_admin')) {
            //判断有没有责任人，如果没有则只向该学院发送提醒通知
            //判断责任人是不是所有人(all)，如果是则向该学院所有人发送通知
            $task_progress = $task->task_progresses()->where(['college_id' => $collegeId])->first();
            $users = new Collection();
            if (isset($task_progress->user_id)) {
                //全体人员
                if ($task_progress->user_id == TaskProgress::$personnelSign) {
                    $users = app(UserRepository::class)->usersWithCollege($collegeId, true);
                } else {
                    $users = $users->merge(app(UserRepository::class)->find(['id', $task_progress->user_id]));
                }
            }
            $users = $users->merge(app(UserRepository::class)->usersWithRoles(['college'])->where('college_id', $collegeId)->all());
            $data = [
                'task_id' => $task->id,
                'college_id' => $collegeId
            ];
            //发送任务提醒通知
            Notification::send($users, new TaskRemind($users, $task));
            app(Remind::class)->create($data);
        } else {
            throw new AuthorizationException("没有操作权限");
        }
    }

    /**
     * 获取催交记录
     * @param $task_id
     * @param $college_id
     * @return mixed
     */
    public function getReminds($task_id, $college_id)
    {
        $conditions = ['task_id' => $task_id, 'college_id' => $college_id];
        return $this->response->array(app(Remind::class)->where($conditions)->get()->toArray());
    }

}
