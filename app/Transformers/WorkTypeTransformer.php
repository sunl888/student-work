<?php

namespace App\Transformers;

use App\Models\WorkType;
use League\Fractal\TransformerAbstract;

class WorkTypeTransformer extends TransformerAbstract
{
    public function transform(WorkType $workType)
    {
        return [
            'id' => $workType->id,
            'title' => $workType->title,
            'created_at' => $workType->created_at->toDateTimeString(),
            'updated_at' => $workType->updated_at->toDateTimeString()
        ];
    }
}
