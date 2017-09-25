<?php

namespace App\Events;

use App\Models\TaskProgress;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class Event
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    public function getUsers($users)
    {
        $userIds = explode(',', $users);
        if (array_first($userIds) != null) {
            if (strtolower(array_first($userIds)) == TaskProgress::$personnelSign) {
                return User::where('college_id', Auth::user()->college_id)->get();
            } elseif (count($userIds) == 1) {
                return User::where('id', array_first($userIds))->get();
            } elseif (count($userIds) > 1) {
                return User::whereIn('id', $userIds)->get();
            }
        } else {
            return null;
        }
    }
}
