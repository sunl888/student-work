<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\College;

class CollegeRepository extends Repository
{
    /*public function model()
    {
        return 'App\Models\College';
    }*/

    public function __construct()
    {
        $this->model = app(College::class);
    }

}