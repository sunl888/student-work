<?php
namespace App\Models\Traits;

trait Helpers
{
    public function scopePage4Api($query)
    {
        $request = request();
        $limitAndOffset = $request->only('limit', 'offset');
        array_walk(
            $limitAndOffset, function (&$val) {
                $val = is_null($val) ? null : intval($val);
            }
        );
        return $query->offset($limitAndOffset['offset'])->limit(is_null($limitAndOffset['limit']) ? config('app.default_per_page') : $limitAndOffset['limit']);
    }
}
