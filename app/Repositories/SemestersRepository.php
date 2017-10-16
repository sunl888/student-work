<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Semester;
use Cache;

class SemestersRepository extends Repository
{
    public function __construct()
    {
        $this->model = app(Semester::class);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->all()->find($id, $columns);
    }

    public function all($columns = array('*'))
    {
        return Cache::remember('semesters', config('app.cache_ttl'), function () {
            return $this->model->all();
        });
    }

    public function create(array $data)
    {
        $this->setChecked($data);
        return $this->model->create($data);
    }

    public function setChecked($data)
    {
        if (isset($data['checked']) && $data['checked'] ==1) {
            // 将所有的checked全部置为 0
            $this->model->update(['checked' => 0]);
        }
    }

    public function update(array $data, $conditions)
    {
        $this->setChecked($data);
        return $this->model->update($data, $conditions);
    }

    public function delete($id)
    {
        return $this->model->delete(['id' => $id]);
    }

}