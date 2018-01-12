<?php

use App\Models\Absentee;
use App\Models\Meeting;
use App\Models\TaskProgress;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('array_swap')) {

    function array_swap(&$array, $i, $j)
    {
        if ($i != $j && array_key_exists($i, $array) && array_key_exists($j, $array)) {
            $temp = $array[$i];
            $array[$i] = $array[$j];
            $array[$j] = $temp;
        }
        return $array;
    }

}


if (!function_exists('get_lead_official')) {

    /**
     * 获取责任人
     * @param $taskProgress
     * @return array
     */
    function get_lead_official($taskProgress)
    {
        if ($taskProgress instanceof Model) {
            $userIds = $taskProgress->user_id;
        } else {
            $userIds = $taskProgress;
        }
        if (!is_array($userIds))
            $userIds = explode(',', $userIds);

        if (array_first($userIds) != null) {
            if (strtolower(array_first($userIds)) == TaskProgress::$personnelSign) {
                return array_values([['id' => 'all', 'name' => '全体人员', 'nickname' => '全体人员']]);
            } elseif (count($userIds) == 1) {
                $user = User::find(array_first($userIds), ['id', 'name', 'nickname']);
                return [$user];
            } elseif (count($userIds) > 1) {
                return User::whereIn('id', $userIds)->get(['id', 'name', 'nickname']);
            }
        } else {
            return null;
        }
    }
}

/**
 * 在用户IDs中提取指定学院的用户
 */
if (!function_exists('getCollegeUsersByAllUsers')) {

    /**
     * @param $users array|string
     * @param $college
     * @return array|mixed
     */
    function getCollegeUsersByAllUsers($users, $college)
    {
        if ($college instanceof \App\Models\College) {
            $college = $college->id;
        }
        if (is_string($users))
            $users = explode(',', $users);

        if (!is_null($users)) {
            // 如果是全体人员则直接返回
            if (strtolower(array_first($users)) == Meeting::ALL_USER) {
                return array_first($users);
            }
            foreach ($users as $index => $user) {
                $user_model = User::find($user);
                if (!isset($user_model) || !isset($user_model->college) || $user_model->college->id != $college) {
                    unset($users[$index]);
                }
            }
        }
        return $users;
    }
}

/**
 * 获取缺勤人员
 */
if (!function_exists('get_absentees')) {
    function get_absentees($metting)
    {
        if ($metting instanceof Meeting) {
            $metting = $metting->id;
        }
        $absentee = Absentee::where(['meeting_id' => $metting])->with('user')->with('assess')->get();
        if ($absentee->isEmpty()) {
            return null;
        }
        return $absentee;
    }

}

if (!function_exists('format_absentees')) {
    function format_absentees($absentees, $college = null)
    {
        if (is_null($absentees))
            return $absentees;
        $results = [];
        if ($college != null) {
            //todo
            $userIds = null;
            foreach ($absentees as $absentee) {
                $userIds[] = Absentee::find($absentee)->user_id;
            }
            if (!is_null($userIds)) {
                $userIds = getCollegeUsersByAllUsers($userIds, $college);
                foreach ($userIds as $userId) {
                    $results[] = User::select(['id', 'name', 'email', 'password', 'picture', 'nickname', 'phone', 'gender'])->find($userId);
                }
            }
        }
        return $results;
    }

}