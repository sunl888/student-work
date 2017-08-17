<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Repository
{
    public function __construct()
    {
        $this->model = app(User::class);
    }

    public function getUsersWithCollege(){
        return $this->model->college()->get();
    }

}