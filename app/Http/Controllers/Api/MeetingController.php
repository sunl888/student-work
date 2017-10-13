<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\CreateMeetingRequest;
use App\Models\Meeting;
use App\Transformers\MeetingTransformer;
use Illuminate\Http\Request;

class MeetingController extends BaseController
{
    public function store(CreateMeetingRequest $request)
    {
        $metting = Meeting::create($request->all());
        //event(new CreatedMeeting($metting->users, $metting));
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
