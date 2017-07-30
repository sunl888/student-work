<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

class TaskRepository extends Repository
{
    public function model()
    {
        return 'App\Models\Task';
    }

    public function lists(){
        return $this->all();
    }

}