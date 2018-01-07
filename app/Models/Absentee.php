<?php

namespace App\Models;
use App\Service\CurrentSemester;

/**
 * Class Absentee
 * @package App\Models
 */
class Absentee extends BaseModel
{
    use CurrentSemester;

    protected $fillable = ['user_id', 'meeting_id', 'assess_id', 'remark', 'id'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function meeting()
    {
        return $this->hasOne(Meeting::class, 'id', 'meeting_id');
    }

    public function assess()
    {
        return $this->hasOne(Assess::class, 'id', 'assess_id');
    }

    public function scopeApplyFilter($query, $data)
    {
        return $query->recent();
    }

}
