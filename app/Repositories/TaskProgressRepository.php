<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Task;
use App\Models\TaskProgress;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TaskProgressRepository extends Repository
{
    public function __construct()
    {
        $this->model = app(TaskProgress::class);
    }

    public function createTaskProgress(array $data, $taskId)
    {
        if ($this->isAutided($taskId)) {
            return $this->model->insert($data);
        }
    }

    /**
     * 判断任务有没有被审核
     * @param $taskId
     * @return mixed
     */
    public function isAutided($taskId)
    {
        if (app(Task::class)->findOrFail($taskId)->isPublish()) {
            return true;
        }
        throw new ModelNotFoundException('任务还没有被审核，暂时不能操作');
    }

    /**
     * 添加责任人
     * @param $data
     */
    public function allotTask($data)
    {
        $data = $data->toArray();
        if ($this->isAutided($data['task_id'])) {
            $conditions = ['task_id' => $data['task_id'], 'college_id' => $data['college_id']];
            $affectRows = $this->update($data, $conditions);
            if ($affectRows <= 0) {
                throw new ModelNotFoundException('添加责任人失败，数据可能已被删除');
            }
        }
    }

    public function submitTask($data)
    {
        $conditions = ['task_id' => $data['task_id'], 'college_id' => $data['college_id']];
        if (($task = $this->hasRecord($conditions)) && $this->isAutided($data['task_id'])) {
            $data['status'] = \Carbon\Carbon::createFromTimestamp(strtotime($data['status']));
            return $task->update(array_except($data, ['task_id', 'college_id']));
        }
        throw new ModelNotFoundException('提交任务失败，该任务不存在');
    }

    public function show(array $conditions)
    {
        return $this->model->where($conditions)->get();
    }

    public function deleteByCollegeId($college_id)
    {
        try {
            return $this->model->where('college_id', $college_id)->delete();
        } catch (\Exception $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

}