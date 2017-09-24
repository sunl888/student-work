<?php

namespace App\Events;

use App\Models\TaskProgress;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

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

    public function getLeadOfficial($users)
    {
        $userIds = explode(',', $users);
        if (array_first($userIds) != null) {
            if (strtolower(array_first($userIds)) == TaskProgress::$personnelSign) {
                return '全体人员';
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
