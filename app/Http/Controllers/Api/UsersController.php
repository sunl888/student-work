<?php


namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Transformers\RoleTransformer;
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
     * 获取用户的角色
     *
     * @param  User $user
     * @return \Dingo\Api\Http\Response
     */
    public function roles(User $user)
    {
        return $this->response->collection($user->roles, new RoleTransformer());
    }
}
