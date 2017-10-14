<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateAssessRequest;
use App\Http\Requests\UpdateAssessRequest;
use App\Models\Assess;
use App\Repositories\AssessRepository;
use App\Transformers\AssessTransformer;

class AssessController extends BaseController
{
    public function lists($type)
    {
        return $this->response->collection(app(AssessRepository::class)->get($type), new AssessTransformer());
    }

    public function store($type, CreateAssessRequest $request)
    {
        $data = $request->only('title', 'score');
        if (in_array($type, [Assess::TYPE_LATE, Assess::TYPE_EXAMINE])) {
            $data['type'] = $type;
            app(AssessRepository::class)->create($data);
        }
        return $this->response->noContent();
    }

    public function update($type, $assessId, UpdateAssessRequest $request)
    {
        app(AssessRepository::class)->update($request->all(), ['id' => $assessId]);
        return $this->response->noContent();
    }

    public function delete($type, $assessId)
    {
        app(AssessRepository::class)->delete($assessId);
        return $this->response->noContent();
    }
}
