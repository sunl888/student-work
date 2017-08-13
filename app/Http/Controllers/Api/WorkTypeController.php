<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateWorkTypeRequest;
use App\Http\Requests\UpdateWorkTypeRequest;
use App\Repositories\WorkTypeRepository;
use App\Transformers\WorkTypeTransformer;

class WorkTypeController extends BaseController
{
    public function lists()
    {
        return $this->response->collection(app(WorkTypeRepository::class)->all(), new WorkTypeTransformer());
    }

    public function store(CreateWorkTypeRequest $request){
        return $this->response->item(app(WorkTypeRepository::class)->create($request->only('title')),new WorkTypeTransformer());
    }

    public function update(UpdateWorkTypeRequest $request, $workId){
        //dd($workId);
        app(WorkTypeRepository::class)->update($request->only('title'),['id'=>$workId]);
        return $this->response->noContent();
    }

    public function delete($workId){
        app(WorkTypeRepository::class)->delete($workId);
        return $this->response->noContent();
    }
}
