<?php

namespace App\Transformers;

use App\Models\Assess;
use League\Fractal\TransformerAbstract;

class AssessTransformer extends TransformerAbstract
{
    public function transform(Assess $assess)
    {
        return [
            'id' => $assess->id,
            'title' => $assess->title,
            'score' => $assess->score,
            'type' => $assess->type,
            'created_at' => $assess->created_at->toDateTimeString(),
            'updated_at' => $assess->updated_at->toDateTimeString()
        ];
    }
}
