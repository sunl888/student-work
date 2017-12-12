<?php


namespace App\Http\Controllers\Api;

use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Service\FileUpload;
use App\Transformers\RoleTransformer;
use App\Transformers\UserTransformer;
use Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends BaseController
{
    use FileUpload;

    public function me()
    {
        return $this->response->item($this->guard()->user(), new UserTransformer());
    }

    /**
     * 显示指定用户信息
     *
     * @param  User $user
     * @return \Dingo\Api\Http\Response
     */
    public function show(User $user)
    {
        $role = $user->roles;
        return $this->response->item($user, new UserTransformer())
            ->addMeta('role', $role);
    }

    /**
     * 用户列表
     * 筛选:学院、角色、性别、
     * @return \Dingo\Api\Http\Response
     */
    public function lists()
    {
        // select * from `e8_users` u left join `e8_role_user` ru on u.id = ru.user_id left join `e8_roles` r on ru.role_id = r.id where u.college_id like "%11%" order by ru.role_id desc

        /*$users = \DB::table('users')
                ->leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
                ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
                ->where('users.college_id','like','%11%')
                ->where('roles.id','=',2)
                ->orderBy('role_user.role_id','asc')
                ->get();*/
        $users = User::leftJoin('role_user', 'users.id', '=', 'role_user.user_id')
            ->leftJoin('roles', 'role_user.role_id', '=', 'roles.id')
            ->withSimpleSearch()
            ->whereHas('roles', function ($query) {
                $role_id = request('role_id', null);
                if ($role_id) {
                    $query->where('roles.id', '=', $role_id);
                }
            })
            ->orderBy('role_user.role_id', 'desc');
        // 获取所有的用户
        if (0 == request('limit')) {
            return $this->response->collection($users->get(), new UserTransformer())
                ->setMeta(User::getAllowSortFieldsMeta() + User::getAllowSearchFieldsMeta());
        } else {
            $users = $users->paginate($this->perPage());
            return $this->response->paginator($users, new UserTransformer())
                ->setMeta(User::getAllowSortFieldsMeta() + User::getAllowSearchFieldsMeta());
        }

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
        $data = $request->all();;
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
        $user = app(User::class)->create($data);
        if (!empty($data['role_id'])) {
            $user->roles()->sync($data['role_id']);
        }
        return $this->response->noContent();
    }

    /**
     * 更新指定用户
     *
     * @param  User $user
     * @param  UserUpdateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(User $user, UserUpdateRequest $request)
    {
        // 管理员可以修改用户角色
        if (Auth::user()->isSuperAdmin()) {
            $data = $request->all();
        } else {
            $data = $request->except(['role_id', 'college_id']);
        }
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        if (Auth::user()->isSuperAdmin()) {
            if (!empty($roleId = $request->get('role_id'))) {
                $user->roles()->sync($roleId);
            }
        }
        return $this->response->noContent();
    }

    /**
     * 删除指定用户
     *
     * @param  User $user
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(User $user)
    {
        $user->roles()->detach();
        $user->delete();
        return $this->response->noContent();
    }
}
