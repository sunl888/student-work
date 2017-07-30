<?php


namespace App\Models;

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
}
