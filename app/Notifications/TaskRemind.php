<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TaskRemind extends Notification
{
    use Queueable;

    protected $task;
    protected $users;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($users, $task)
    {
        $this->task = $task;
        $this->users = $users;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => '您有一个任务提醒：' . $this->task->title,
            'task_id' => $this->task->id,
            'title' => $this->task->title,
            'detail' => $this->task->detail,
            'created_at' => $this->task->created_at,
        ];
    }
}
