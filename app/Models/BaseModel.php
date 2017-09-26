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
    public function scopeRange($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }

    public function scopeOrderByKey($query)
    {
        return $query->orderBy($this->getKeyName(), 'ASC');
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
