<?php

namespace App\Http\Controllers\Api;

use App\Events\CreatedMeeting;
use App\Http\Requests\CreateMeetingRequest;
use App\Models\Meeting;
use App\Transformers\MeetingTransformer;

class MeetingController extends BaseController
{
    public function store(CreateMeetingRequest $request)
    {
        $metting = Meeting::create($request->all());
        event(new CreatedMeeting($metting->users, $metting));
        return $this->response()->noContent();
    }

    public function lists(){
        return $this->response()->collection(Meeting::all(), new MeetingTransformer());
    }
}
