<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

class WorkTypeRepository extends Repository
{
    public function model()
    {
        return 'App\Models\WorkType';
    }

    /*public function delete($id)
    {
        //删除模型  destroy(array)
        return $this->model->where(['id'=>$id])->delete();
    }*/
}