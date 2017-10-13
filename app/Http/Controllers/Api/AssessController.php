<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateAssessRequest;
use App\Http\Requests\UpdateAssessRequest;
use App\Models\Assess;
use App\Repositories\AssessRepository;
use App\Transformers\AssessTransformer;
use Illuminate\Http\Request;

class AssessController extends BaseController
{
    public function lists(Request $filter)
    {
        return $this->response->collection(app(AssessRepository::class)->get($filter), new AssessTransformer());
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

    public function update(UpdateAssessRequest $request, $assessId)
    {
        app(AssessRepository::class)->update($request->all(), ['id' => $assessId]);
        return $this->response->noContent();
    }

    public function delete($assessId)
    {
        app(AssessRepository::class)->delete($assessId);
        return $this->response->noContent();
    }
}
