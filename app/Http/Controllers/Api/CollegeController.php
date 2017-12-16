<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateCollegeRequest;
use App\Http\Requests\UpdateCollegeRequest;
use App\Repositories\CollegeRepository;
use App\Repositories\TaskProgressRepository;
use App\Transformers\CollegeTransformer;

class CollegeController extends BaseController
{

    public function lists()
    {
        return $this->response->collection(app(CollegeRepository::class)->all(), new CollegeTransformer());
    }

    public function store(CreateCollegeRequest $request)
    {
        app(CollegeRepository::class)->create($request->only('title'));
        return $this->response->noContent();
    }

    public function update(UpdateCollegeRequest $request, $CollegeId)
    {
        app(CollegeRepository::class)->update($request->only('title'), ['id' => $CollegeId]);
        return $this->response->noContent();
    }

    public function delete($CollegeId)
    {
        app(CollegeRepository::class)->delete($CollegeId);
        app(TaskProgressRepository::class)->deleteByCollegeId($CollegeId);
        return $this->response->noContent();
    }
}