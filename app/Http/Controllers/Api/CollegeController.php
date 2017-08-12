<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateCollegeRequest;
use App\Http\Requests\UpdateCollegeRequest;
use App\Repositories\CollegeRepository;
use App\Transformers\CollegeTransformer;

class CollegeController extends BaseController
{
    /*public function __construct()
    {
        $this->middleware('role:super_admin');
    }*/

    public function lists()
    {
        return $this->response->collection(app(CollegeRepository::class)->all(), new CollegeTransformer());
    }

    public function store(CreateCollegeRequest $request)
    {
        return $this->response->item(app(CollegeRepository::class)->create($request->only('title')), new CollegeTransformer());
    }

    public function update(UpdateCollegeRequest $request, $CollegeId)
    {
        app(CollegeRepository::class)->update($request->only('title'), ['id' => $CollegeId]);
        return $this->response->noContent();
    }

    public function delete($CollegeId)
    {
        app(CollegeRepository::class)->delete($CollegeId);
        return $this->response->noContent();
    }
}