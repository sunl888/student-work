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
     * 获取学院下的所有用户
     * @return \Dingo\Api\Http\Response
     */
    public function usersWithCollege()
    {
        $users = app(User::class)->where(['college_id' => $this->guard()->user()->college_id])->get();
        if ($users->count() > 0) {
            return $this->response->collection($users->except($this->guard()->user()->id), new UserTransformer());
        }
        return $this->response->noContent();
    }

    public function getCollegeUsers(){
        dd(app(UserRepository::class)->getUsersWithCollege());
    }
}
