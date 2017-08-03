<?php

namespace App\Http\Controllers\Api;

use App\Repositories\DepartmentRepository;
use App\Transformers\DepartmentTransformer;

class DepartmentController extends BaseController
{
    public function lists(){
        return $this->response->collection(app(DepartmentRepository::class)->all(), new DepartmentTransformer());
    }
}
