<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Assess;

class AssessRepository extends Repository
{
    /*public function model()
    {
        return 'App\Models\Assess';
    }*/
    public function __construct()
    {
        $this->model = app(Assess::class);
    }


}