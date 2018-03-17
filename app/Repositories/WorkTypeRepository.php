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
use App\Models\WorkType;
use Cache;

class WorkTypeRepository extends Repository
{
    public function __construct()
    {
        $this->model = app(WorkType::class);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->all()->find($id, $columns);
    }

    public function all($columns = array('*'))
    {
        return Cache::remember('work_types', config('app.cache_ttl'), function () {
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

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        // TODO 这里可能需要优化
        // 2018/3/17
        // 当删除会议类型时会真删除相关联的会议
        $task_ids = Task::ByKey('work_type_id', $id)->pluck('id');
        TaskProgress::whereIn('task_id', $task_ids)->forceDelete();
        Task::ByKey('work_type_id', $id)->forceDelete();
        return $this->model->delete(['id' => $id]);
    }
}