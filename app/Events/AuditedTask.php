<?php

namespace App\Events;

use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AuditedTask extends Task
{

    public $users = null;

    public function __construct($task)
    {
        parent::__construct($task);
        //获取所有的二级学院用户
        $this->users = app(UserRepository::class)->usersWithRoles(['college']);
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
