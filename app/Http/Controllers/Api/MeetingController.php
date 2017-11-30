<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateMeetingRequest;
use App\Models\Absentee;
use App\Models\Meeting;
use App\Transformers\MeetingTransformer;
use Illuminate\Http\Request;

class MeetingController extends BaseController
{
    public function store(CreateMeetingRequest $request)
    {
        $data = $request->all();
        $data['start_time'] = \Carbon\Carbon::createFromTimestamp(strtotime($data['start_time']));
        $meeting = Meeting::create($data);
        // 判断哪些人缺勤，分别为他们创建缺勤记录
        if (isset($data['absent_cause'])) {
            array_walk($data['absent_cause'], function (&$value, $key, $joinUsing) {
                $value[$joinUsing['key']] = $joinUsing['val'];
            }, array('key' => 'meeting_id', 'val' => $meeting->id));
            // 将每个用户的缺勤记录存入数据库
            array_walk($data['absent_cause'], function (&$val) {
                Absentee::create($val);
            });
        }
        // event(new CreatedMeeting($meeting->users, $meeting));
        return $this->response()->noContent();
    }

    public function lists(Request $request)
    {
        return $this->response()->paginator(Meeting::applyFilter($request)->paginate($this->perPage()), new MeetingTransformer());
    }

    public function show(Meeting $meeting)
    {
        return $this->response()->item($meeting, new MeetingTransformer());
    }
}
