<?php

namespace App\Transformers;

use App\Models\Meeting;
use App\Models\TaskProgress;
use App\Models\User;

class MeetingTransformer extends Transformer
{
    public function transform(Meeting $meeting)
    {
        return [
            'id' => $meeting->id,
            'title' => $meeting->title,
            'users' => $this->getLeadOfficial($meeting->users),
            'detail' => $meeting->detail,
            'created_at' => $meeting->created_at->toDateTimeString(),
            'updated_at' => $meeting->updated_at->toDateTimeString()
        ];
    }

    public function getLeadOfficial($users)
    {
        $userIds = explode(',', $users);
        if (array_first($userIds) != null) {
            if (strtolower(array_first($userIds)) == TaskProgress::$personnelSign) {
                return ['name'=>'全体人员'];
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
