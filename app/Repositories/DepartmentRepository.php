<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository extends Repository
{
    /*public function model()
    {
        return 'App\Models\Department';
    }*/

    public function __construct()
    {
        $this->model = app(Department::class);
    }
}