<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2017/8/22
 * Time: 18:54
 */

namespace App\Service;

use App\Repositories\SemestersRepository;

trait CurrentSemester
{
    /**
     * 当前学期
     * @param $query
     * @param $start
     * @param $end
     * @return mixed
     */
    public function scopeRange($query, $start, $end)
    {
        return $query->whereBetween('created_at', [$start, $end]);
    }


    public function scopeCurrentSemester($query)
    {
        $current_Semester = app(SemestersRepository::class)->where(['checked' => 1])->first();
        return $query->range($current_Semester->start_time, $current_Semester->end_time);
    }

}