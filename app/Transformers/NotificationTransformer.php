<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class NotificationTransformer extends TransformerAbstract
{
    public function transform($notications)
    {
        return [
            'data' => json_decode($notications->data),
            'type' => $notications->type,
        ];
    }
}
