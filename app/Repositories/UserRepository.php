<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;

class UserRepository extends Repository
{
    public function __construct()
    {
        $this->model = app(User::class);
    }

    /**
     * 获取所有的role下的用户
     * @param array $roles
     * @return Collection|static
     */
    public function usersWithRoles(array $roles){
        $roles = app(Role::class)->whereIn('name',$roles)->get();
        $users = new \Illuminate\Database\Eloquent\Collection();
        foreach ($roles as $role){
            $temp = $role->users()->get();
            $users = $users->merge($temp);
        }
        return $users->unique();
    }
    //1 3 4
}