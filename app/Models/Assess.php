<?php

namespace App\Models;

use App\Models\Traits\Cachable;
use Cache;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assess extends BaseModel
{
    // examine 考核评分
    const TYPE_EXAMINE = 'examines';
    // late  推迟理由
    const TYPE_LATE = 'lates';

    protected $fillable = ['title', 'score', 'type'];

    use SoftDeletes {
        restore as private restoreA;
    }
    use Cachable {
        restore as private restoreB;
    }
    protected $guarded = [];

    protected $table = 'assess';

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function clearCache()
    {
        Cache::forget('assess');
    }

    public function scopeByType($query, $type)
    {
        if (in_array($type, [static::TYPE_EXAMINE, static::TYPE_LATE]))
            return $query->where('type', $type);
        else
            return $query->examineOrLate();
    }

    public function scopeExamine($query)
    {
        return $query->where('type', 'examines');
    }

    public function scopeLate($query)
    {
        return $query->where('type', 'lates');
    }

    public function scopeExamineOrLate($query)
    {
        return $query->where('type', static::TYPE_EXAMINE)->orWhere('type', static::TYPE_LATE);
    }

    public function scopeApplyFilter($query, $data)
    {
        $data = $data->only('type');
        if (in_array($data['type'], [static::TYPE_LATE, static::TYPE_EXAMINE])) {
            $query->byType(isset($data['type']) ? $data['type'] : null);
        }
        return $query->recent();
    }
}
