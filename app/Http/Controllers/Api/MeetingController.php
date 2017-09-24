<?php

namespace App\Http\Controllers\Api;

use App\Events\CreatedMeeting;
use App\Http\Requests\CreateMeetingRequest;
use App\Http\Controllers\Controller;
use App\Models\Meeting;

class MeetingController extends Controller
{
    public function store(CreateMeetingRequest $request)
    {
        $metting = Meeting::create($request->all());
        event(new CreatedMeeting($metting->users, $metting));
        return $this->response->noContent();
    }
}
