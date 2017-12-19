<?php

namespace App\Transformers;

use App\Models\College;
use League\Fractal\TransformerAbstract;

class CollegeTransformer extends TransformerAbstract
{
    public function transform($college)
    {
        if ($college instanceof College) {
            return [
                'id' => $college->id,
                'title' => $college->title,
                'created_at' => $college->created_at->toDateTimeString(),
                'updated_at' => $college->updated_at->toDateTimeString()
            ];
        }
        return $this->null();
    }
}
