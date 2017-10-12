<?php

namespace App\Models;

use App\Models\Traits\Cachable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Semester extends BaseModel
{
    protected $fillable = ['title', 'start_time', 'end_time', 'parent_id'];
    protected $hidden = ['deleted_at'];
    protected $table = 'semesters';
    use SoftDeletes {
        restore as private restoreA;
    }
    use Cachable {
        restore as private restoreB;
    }

    public function restore()
    {
        $this->restoreA();
        $this->restoreB();
    }

    public function clearCache()
    {
        Cache::forget('semesters');
    }

    public function parent()
    {
        return $this->hasOne(Semester::class, 'id', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Semester::class, 'parent_id', 'id');
    }

    public function scopeByParentId($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    /*public function getParent($parent)
    {
        return $this->where('id', $parent)->get();
    }

    public function __toString()
    {
        $this->parent->title;
        $this->title;
        $str = '(' . $this->title . ')';
        if (!is_null($this->parent)) {
            $str = $this->parent->title . $str;
        }
        return $str;
    }*/

}
