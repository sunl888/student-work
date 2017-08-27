<?php

namespace App\Listeners;

use App\Events\TaskSaved;

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
     * @param  $event
     * @return void
     */
    public function handle($event)
    {
        if ($event instanceof TaskSaved) {
            //
        }
    }
}
