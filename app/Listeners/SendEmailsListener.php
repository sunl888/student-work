<?php

namespace App\Listeners;

use App\Events\TaskSaved;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendEmailsListener
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
     * @param  TaskSaved  $event
     * @return void
     */
    public function handle(TaskSaved $event)
    {
        //发送邮件
    }
}
