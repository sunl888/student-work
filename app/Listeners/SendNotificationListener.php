<?php

namespace App\Listeners;

use App\Events\AuditedTask;
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
            Notification::send();
        }
    }
}
