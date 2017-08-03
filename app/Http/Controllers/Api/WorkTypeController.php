<?php

namespace App\Http\Controllers\Api;

use App\Repositories\WorkTypeRepository;
use App\Transformers\WorkTypeTransformer;
use Illuminate\Http\Request;

class WorkTypeController extends BaseController
{
    public function lists(){
        return $this->response->collection(app(WorkTypeRepository::class)->all(), new WorkTypeTransformer());
    }
}
