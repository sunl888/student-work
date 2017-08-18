<?php

namespace App\Listeners;

use App\Events\AuditedTask;
use App\Events\TaskAlloted;
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
        //审核成功
        if ($event instanceof AuditedTask) {
            $users = app(UserRepository::class)->usersWithRoles(['college']);
            Notification::send($users, new TaskAudited($event->task));
        }elseif ($event instanceof TaskAlloted){
            //指定了责任人
            Notification::send($event->users, new \App\Notifications\TaskAlloted($event->task));
        }
    }
}
