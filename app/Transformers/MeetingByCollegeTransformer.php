<?php

namespace App\Transformers;

use App\Models\Meeting;

class MeetingByCollegeTransformer extends Transformer
{
    public function transform(Meeting $meeting)
    {
        dd($meeting);
        return [
            'id' => $meeting->id,
            'title' => $meeting->title,
            'users' => get_lead_official($meeting->users),
            'detail' => $meeting->detail,
            'address' => $meeting->address,
            'start_time' => $meeting->start_time,
            'absentees' => get_absentees($meeting->id),
            'meeting_total_score' => $meeting->meeting_total_score,
            'created_at' => $meeting->created_at->toDateTimeString(),
            'updated_at' => $meeting->updated_at->toDateTimeString()
        ];
    }
}
