<?php

namespace App\Models;

use App\Models\Traits\Listable;

/**
 * Class Meeting
 * @method static applyFilter($data)
 * @package App\Models
 */
class Meeting extends BaseModel
{
    use Listable;

    protected static $allowSearchFields = ['title', 'detail'];
    protected static $allowSortFields = ['id'];
    protected $fillable = ['id', 'title', 'detail', 'address', 'start_time', 'late_id', 'users'];

    const BASE_COURSE = 50;

    public function scopeApplyFilter($query, $data)
    {
        $data = $data->only('user');
        $query->withSimpleSearch()
            ->withSort();
        if (isset($data['user'])) {
            $query->byUser($data['user']);
        }
        return $query->recent();
    }

    public function scopebyUser($query, $user)
    {
        return $query->orWhere('users', 'like', '%' . ",$user," . '%')
            ->orWhere('users', 'like', "$user," . '%')
            ->orWhere('users', 'like', '%' . ",$user");
    }

}
