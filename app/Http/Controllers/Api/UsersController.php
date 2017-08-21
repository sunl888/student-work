<?php


namespace App\Http\Controllers\Api;

use App\Http\Requests\UserCreateRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Transformers\RoleTransformer;
use App\Transformers\UserTransformer;
use Hash;

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

    /**
     * 创建用户
     *
     * @param  UserCreateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(UserCreateRequest $request)
    {
        $data = $request->all();
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        if($request->hasFile('picture')){
            $path = $request->file('picture')->store('pictures');
        }
        $data['picture'] = isset($path)?$path:null;

        //$user = app(User::class)->create($data);
        if (!empty($data['role_id'])) {
            $roleId = app(Role::class)->findOrFail($data['role_id'])->only('id');
            dd($roleId);
            $user->roles()->sync($roleId);
        }
        return $this->response->noContent();
    }
}
