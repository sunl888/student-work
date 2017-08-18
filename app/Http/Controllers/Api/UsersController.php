<?php


namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Transformers\UserTransformer;

class UsersController extends BaseController
{
    public function me()
    {
        return $this->response->item($this->guard()->user(), new UserTransformer());
    }

    /**
     * 获取当前学院下的所有用户
     * @return \Dingo\Api\Http\Response
     */
    public function usersWithCollege($collegeId = null)
    {
        return $this->response->item(app(UserRepository::class)->usersWithCollege($collegeId), new UserTransformer());
    }

    /**
     * 获取没有阅读的通知
     */
    public function unreadNotifications(){
        $user = $this->guard()->user();
        foreach ($user->unreadNotifications as $notification) {
            dd($notification);
        }
    }
}
