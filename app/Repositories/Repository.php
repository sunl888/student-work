<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/27
 * Time: 15:20
 */

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryContract;

abstract class Repository implements RepositoryContract
{
    protected $model;

    public function hasRecord(array $conditions)
    {
        if ($conditions != null) {
            return $this->model->where($conditions)->first();
        }
    }

    public function all($columns = array('*'))
    {
        return $this->model->get($columns);
    }

    public function paginate($perPage = 15, $columns = array('*'))
    {
        return $this->model->paginate($perPage, $columns);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $conditions)
    {
        return $this->model->where($conditions)->update($data);
    }

    public function delete($id)
    {
        return $this->model->where(['id' => $id])->delete();
    }

    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function where($conditions){
        return $this->model->where($conditions);
    }

}