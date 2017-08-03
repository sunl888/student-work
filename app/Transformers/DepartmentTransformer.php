<?php

namespace App\Transformers;

use App\Models\Department;
use League\Fractal\TransformerAbstract;

class DepartmentTransformer extends TransformerAbstract
{
    public function transform(Department $department)
    {
        return [
            'id' => $department->id,
            'title' => $department->title,
            'created_at' => $department->created_at->toDateTimeString(),
            'updated_at' => $department->updated_at->toDateTimeString()
        ];
    }
}
