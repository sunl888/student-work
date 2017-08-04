<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/27
 * Time: 15:20
 */

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Container\Container as Application;

abstract class Repository implements RepositoryContract
{
    protected $app;

    protected $model;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->makeModel();
    }

    /**
     * model的名字
     * @return mixed
     */
    abstract function model();


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
        //return $this->model->destroy($id);
        return $this->model->where(['id'=>$id])->delete();
    }

    public function find($id, $columns = array('*'))
    {
        return $this->model->find($id, $columns);
    }

    public function findBy($attribute, $value, $columns = array('*'))
    {
        return $this->model->where($attribute, '=', $value)->first($columns);
    }

    public function makeModel()
    {
        $model = $this->app->make($this->model());
        if (!$model instanceof Model)
            throw new \Exception("Class {$this->model()} must be an instance of Illuminate\\Database\\Eloquent\\Model");
        return $this->model = $model->newQuery();
    }
}