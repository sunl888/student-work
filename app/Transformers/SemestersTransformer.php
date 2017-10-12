<?php

namespace App\Transformers;

use App\Models\Assess;
use App\Models\Semester;
use League\Fractal\TransformerAbstract;

class SemestersTransformer extends TransformerAbstract
{
    public function transform(Semester $semester)
    {
        return [
            'id' => $semester->id,
            'title' => $semester->title,
            'start_time' => $semester->start_time,
            'end_time' => $semester->end_time,
            'parent_id' =>$semester->parent_id,
            'parent' =>$semester->parent,
            'checked' =>$semester->checked,
            'created_at' => $semester->created_at->toDateTimeString(),
            'updated_at' => $semester->updated_at->toDateTimeString()
        ];
    }
}
