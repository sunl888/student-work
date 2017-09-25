<?php

namespace App\Listeners;

use App\Events\AuditedTask;
use App\Events\CreatedMeeting;
use App\Events\TaskAlloted;
use App\Notifications\TaskAudited;
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
     * @param  AuditedTask $event
     * @return void
     */
    public function handle($event)
    {
        //审核成功
        if ($event instanceof AuditedTask) {
            Notification::send($event->users, new TaskAudited($event->task));
        } elseif ($event instanceof TaskAlloted) {
            //指定了责任人向对应的责任人发送通知
            Notification::send($event->users, new \App\Notifications\TaskAlloted($event->task));
        } elseif ($event instanceof CreatedMeeting) {
            //会议通知
            Notification::send($event->users, new \App\Notifications\CreatedMeeting($event->metting));
        }
    }
}
