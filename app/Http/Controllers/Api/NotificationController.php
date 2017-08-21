<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;

class NotificationController extends BaseController
{
    /**
     * 获取未读通知
     */
    public function unReadNotifications(){
        $user = $this->guard()->user();
        $notifys = $user->unReadNotifications;
        return $this->response->array($notifys);
        //return $this->response->item($notifys, new NotificationTransformer());
    }

    /**
     * 所有通知
     * @return mixed
     */
    public function notifications(){
        $user = $this->guard()->user();
        $notifys = $user->notifications;
        return $this->response->array($notifys);
    }

    /**
     * 设置通知状态为已读
     * @return \Dingo\Api\Http\Response
     */
    public function markNotifysAsRead(){
        $user = $this->guard()->user();
        $user->unreadNotifications()->update(['read_at' => Carbon::now()]);
        return $this->response->noContent();
    }
}
