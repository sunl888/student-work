<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2017/9/24
 * Time: 9:40
 */

namespace App\Notifications;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class CreatedMeeting extends Notification implements ShouldQueue
{
    use Queueable;

    protected $metting;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($metting)
    {
        $this->metting = $metting;
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
     * 定义数据保存到数据库中的格式
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id' =>$this->metting->id,
            'title' => $this->metting->title,
            'detail' => $this->metting->detail,
            'created_at' => $this->metting->created_at,
            'message' => '会议通知：您有一个新会议：' . $this->metting->title,
        ];
    }

}