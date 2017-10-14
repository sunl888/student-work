<?php

namespace App\Models;

/**
 * Class Absentee
 * @package App\Models
 */
class Absentee extends BaseModel
{
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

}
