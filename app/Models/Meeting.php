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

    public static $score = [
        [
            'title' => '已到',
            'score' => 70
        ], [
            'title' => '迟到',
            'score' => 60
        ], [
            'title' => '未到',
            'score' => 50
        ]];
    protected static $allowSearchFields = ['title', 'detail'];
    protected static $allowSortFields = ['id'];
    protected $fillable = ['title', 'detail', 'start_time', 'users'];

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
