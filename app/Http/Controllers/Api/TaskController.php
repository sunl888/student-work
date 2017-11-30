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
use App\Notifications\TaskRemind;
use App\Repositories\CollegeRepository;
use App\Repositories\DepartmentRepository;
use App\Repositories\TaskProgressRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkTypeRepository;
use App\Service\Export2Excel;
use App\Transformers\TaskAndProgressTransformer;
use App\Transformers\TaskOfTeacherTransformer;
use App\Transformers\TaskTransformer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Notification;

class TaskController extends BaseController
{
    use Export2Excel;

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
            $data = $taskRequest->all();
            if (isset($data['end_time'])){
                $data['end_time'] = \Carbon\Carbon::createFromTimestamp(strtotime($data['end_time']));
            }
            $task = $this->taskRepository->createTask($data);
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
            $data = $request->all();
            if (isset($data['end_time'])){
                $data['end_time'] = \Carbon\Carbon::createFromTimestamp(strtotime($data['end_time']));
            }
            $this->taskRepository->updateTask($data, $taskId);
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

    public function export2table(Request $request)
    {
        $tasks = Task::applyFilter($request)->get()->load('task_progresses');
        $rows = ['任务ID', '标题', '详情', '结束时间', '工作类型', '对口科室', '学院名称', '完成状态', '责任人'];
        $data = [];
        foreach ($tasks as $task) {
            foreach ($task->task_progresses as $progress) {
                $data[] = [
                    $task->id,
                    $task->title,
                    $task->detail,
                    $task->end_time,
                    app(WorkTypeRepository::class)->find($task->work_type_id)['title'],
                    app(DepartmentRepository::class)->find($task->department_id)['title'],
                    app(CollegeRepository::class)->find($progress->college_id)['title'],
                    $progress->status ? '已完成' : '未完成',
                    isset($progress->user_id) ? $this->getUsersName($progress->user_id) : null,
                ];
            }
        }
        $tableName = $request->has('start_time') ? $request->get('start_time') . ' - 任务汇总表' : '任务汇总表';
        $this->export($rows, $data, $tableName);
    }

    /**
     * @param $userIds
     * @return mixed|null|string
     * @version 1.1 返回用户nickname信息【v1.0返回的是用户name信息】
     */
    public function getUsersName($userIds)
    {
        if ($userIds instanceof Model) {
            $userIds = explode(',', $userIds->user_id);
        } else {
            $userIds = explode(',', $userIds);
        }
        $tmp = '';
        if (array_first($userIds) != null) {
            if (strtolower(array_first($userIds)) == TaskProgress::$personnelSign) {
                return '全体人员';
            } elseif (count($userIds) == 1) {
                $user = User::find(array_first($userIds));
                return $user->nickname;
            } elseif (count($userIds) > 1) {
                $users = User::whereIn('id', $userIds)->get();
                foreach ($users as $user) {
                    $tmp .= $user->nickname . ',';
                }
                $tmp = str_replace_last(',', '', $tmp);
                return $tmp;
            }
        } else {
            return null;
        }
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
            $condisions['college_id'] = Auth::user()->college_id;
        }
        return $this->response()->paginator($this->taskRepository->tasksByCollege($this->perPage(), $condisions), new TaskAndProgressTransformer());
    }

    public function getTasksByTeacher()
    {
        $tasks = app(TaskProgress::class)->asUsers(Auth::id())->with(['task' => function ($query) {
            $query->publish();
        }])->get();
        $res = new Collection();
        foreach ($tasks as $task) {
            if (!is_null($task->task)) {
                $res->push($task);
            }
        }
        $pages = $res->forPage(request('page') ?: 1, $this->perPage());
        $page = new LengthAwarePaginator($pages, count($res), $this->perPage());
        return $this->response()->paginator($page, new TaskOfTeacherTransformer());
    }

    public function task(Task $task)
    {
        return $this->response->item(Task::findOrFail($task->id), new TaskTransformer());
    }

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
