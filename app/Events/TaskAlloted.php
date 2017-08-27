<?php

namespace App\Events;

use App\Models\TaskProgress;
use App\Repositories\UserRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;

class TaskAlloted extends Task
{
    public $users = null;

    public function __construct($request)
    {

        parent::__construct($request->task_id);

        if ($request->user_id == TaskProgress::$personnelSign) {
            $this->users = app(UserRepository::class)->usersWithCollege($request->college_id);
        } else {
            $this->users = app(UserRepository::class)->find($request->user_id);
        }
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
}
