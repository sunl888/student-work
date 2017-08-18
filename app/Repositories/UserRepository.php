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
     * 获取roles下的所有用户
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

    /**
     * 获取学院下的所有用户
     * @return \Dingo\Api\Http\Response
     */
    public function usersWithCollege($collegeId = null)
    {
        if (null == $collegeId){
            $collegeId = \Auth::guard()->user()->college_id;
        }
        $users = $this->usersWithRoles(['teacher'])->where('college_id',$collegeId);
        return $users;
    }

}