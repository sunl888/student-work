<?php


namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    protected $hasDefaultValuesFields = [];

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeAncient($query)
    {
        return $query->orderBy('created_at', 'asc');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'desc');
    }

    public function scopeOrderByKey($query)
    {
        return $query->orderBy($this->getKeyName(), 'ASC');
    }

    /**
     * 过滤有默认值的字段并且字段的值为null的数组
     *
     * @param  $data
     * @return mixed
     */
    public function filterNullWhenHasDefaultValue($data)
    {
        foreach ($this->hasDefaultValuesFields as $key) {
            if (array_key_exists($key, $data) && is_null($data[$key])) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    public function fill(array $attributes)
    {
        return parent::fill($this->filterNullWhenHasDefaultValue($attributes));
    }

    //todo 这里用来将时间描述成n分钟前
    /*public function getCreatedAtAttribute($date)
    {
        // 默认100天前输出完整时间，否则输出人性化的时间
        if (Carbon::now() > Carbon::parse($date)->addDays(100)) {
            return Carbon::parse($date);
        }

        return Carbon::parse($date)->diffForHumans();
    }*/
}
