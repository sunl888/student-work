<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Assess;
use Cache;

class AssessRepository extends Repository
{
    public function __construct()
    {
        $this->model = app(Assess::class);
    }

    public function find($id, $columns = array('*'))
    {
        return $this->all()->find($id, $columns);
    }

    public function all($columns = array('*'))
    {
        return Cache::remember('assess', config('app.cache_ttl'), function () {
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
        return $this->model->delete(['id' => $id]);
    }

}