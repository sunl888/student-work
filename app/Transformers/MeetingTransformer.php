<?php

namespace App\Transformers;

use App\Models\Absentee;
use App\Models\Meeting;
use App\Models\User;
use Dingo\Api\Facade\Route;

class MeetingTransformer extends Transformer
{
    public function transform(Meeting $meeting)
    {
        // 如果是会议详情则显示每个学员的情况，否则不显示
        $isNotShowDetails = !(Route::currentRouteName() === 'metting.show');
        return [
            'id' => $meeting->id,
            'title' => $meeting->title,
            'users' => get_lead_official($meeting->users),
            'detail' => $meeting->detail,
            'address' => $meeting->address,
            'start_time' => $meeting->start_time,
            'detail_of_colleges' => $isNotShowDetails ? '此列只在会议详情里显示' : $this->getDetailOfColleges($meeting),
            'absentees' => get_absentees($meeting->id),
            'created_at' => $meeting->created_at->toDateTimeString(),
            'updated_at' => $meeting->updated_at->toDateTimeString()
        ];
    }

    public function getDetailOfColleges(Meeting $meeting)
    {
        $datas = [];
        $user = app(User::class);
        $absentee = app(Absentee::class);
        if ($meeting->users == 'all') {
            // 去除管理员账号
            $users = $user->get()->filter(function ($user) {
                if ($user->isNotSuperAdmin()) {
                    return $user;
                } else {
                    return;
                }
            })->pluck('id');
        } else {
            $users = explode(',', $meeting->users);
        }
        foreach ($users as $user_id) {
            $uInfo = $user->find($user_id);
            $data = $absentee->where('user_id', $user_id)->where('meeting_id', $meeting->id)->first();
            if (!isset($datas[$uInfo->college->title]['score'])) {
                $datas[$uInfo->college->title]['score'] = Meeting::BASE_SCORE;
            }
            $userinfo = collect();
            $userinfo->push($uInfo->toArray());
            if (!is_null($data)) {
                if ($datas[$uInfo->college->title]['score'] > 0)
                    // todo 这里必须是负数
                    $datas[$uInfo->college->title]['score'] += $data->assess->score;
                $userinfo->push($data->assess->toArray());
                $datas[$uInfo->college->title]['users'][] = $userinfo;
            } else {
                $datas[$uInfo->college->title]['users'][] = $userinfo;
            }
            unset($data, $uInfo);
        }
        return $datas;
    }
}
