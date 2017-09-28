<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 16:14
 */

namespace App\Transformers;

use App\Models\TaskProgress;
use App\Models\User;
use League\Fractal\TransformerAbstract;

class Transformer extends TransformerAbstract
{
    /**
     * 获取责任人
     * @param $taskProgress
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|string|static|static[]
     */
    public function getLeadOfficial($taskProgress)
    {
        $userIds = explode(',', $taskProgress->user_id);
        if (array_first($userIds) != null) {
            if (strtolower(array_first($userIds)) == TaskProgress::$personnelSign) {
                return array_values(['name' => '全体人员']);
            } elseif (count($userIds) == 1) {
                return User::find(array_first($userIds), ['id', 'name']);
            } elseif (count($userIds) > 1) {
                return User::whereIn('id', $userIds)->get(['id', 'name']);
            }
        } else {
            return null;
        }
    }

}