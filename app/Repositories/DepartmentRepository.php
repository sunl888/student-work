<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Department;
use App\Models\Task;
use App\Models\TaskProgress;
use Cache;

class DepartmentRepository extends Repository
{

    public function __construct()
    {
        $this->model = app(Department::class);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->all()->find($id, $columns);
    }

    public function all($columns = array('*'))
    {
        return Cache::remember('departments', config('app.cache_ttl'), function () {
            return $this->model->all();
        });
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $conditions)
    {
        return $this->model->update($data, $conditions);
    }

    public function delete($id)
    {
        // TODO 删除对口科室的同事删除相关联的任务
        $task_ids = Task::ByKey('department_id', $id)->pluck('id');
        TaskProgress::whereIn('task_id', $task_ids)->forceDelete();
        Task::ByKey('department_id', $id)->forceDelete();
        return $this->model->delete(['id' => $id]);
    }
}