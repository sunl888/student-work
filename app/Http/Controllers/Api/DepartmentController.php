<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Repositories\DepartmentRepository;
use App\Transformers\DepartmentTransformer;

class DepartmentController extends BaseController
{
    public function lists()
    {
        return $this->response->collection(app(DepartmentRepository::class)->all(), new DepartmentTransformer());
    }

    public function store(CreateDepartmentRequest $request)
    {
        return $this->response->item(app(DepartmentRepository::class)->create($request->only('title')), new DepartmentTransformer());
    }

    public function update(UpdateDepartmentRequest $request, $DepartmentId)
    {
        app(DepartmentRepository::class)->update($request->only('title'), ['id' => $DepartmentId]);
        return $this->response->noContent();
    }

    public function delete($DepartmentId)
    {
        app(DepartmentRepository::class)->delete($DepartmentId);
        return $this->response->noContent();
    }
}
