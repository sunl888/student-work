<?php

namespace App\Transformers;

use App\Models\Meeting;

class MeetingTransformer extends Transformer
{
    public function transform(Meeting $meeting)
    {
        return [
            'id' => $meeting->id,
            'title' => $meeting->title,
            'users' => get_lead_official($meeting->users),
            'detail' => $meeting->detail,
            'address' =>$meeting->address,
            'start_time' =>$meeting->start_time,
            'absentees' => get_absentees($meeting->id),
            'created_at' => $meeting->created_at->toDateTimeString(),
            'updated_at' => $meeting->updated_at->toDateTimeString()
        ];
    }

    /*public function getLeadOfficial($users)
    {
        $userIds = explode(',', $users);
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
    }*/
}
