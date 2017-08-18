<?php

namespace App\Listeners;

use App\Events\AuditedTask;
use App\Notifications\TaskAudited;
use App\Repositories\UserRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AuditedTask  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event instanceof AuditedTask) {
            $users = app(UserRepository::class)->usersWithRoles(['college']);
            Notification::send($users, new TaskAudited($event->task));
        }
    }
}
