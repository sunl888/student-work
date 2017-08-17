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
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function usersWithRole($role){
        $roles = Role::whereIn('name',['college','teacher'])->get();
        $users = new Collection();
        foreach ($roles as $role){
            $temp = $role->users()->get();
            $temp->filter(function ($value, $users) {
                if(!$users->has($value->name)){
                    //$users = $users->merge($temp);
                }
            });
            if(!$users->has($temp->name)){
                $users = $users->merge($temp);
            }
        }
        dd($users->toArray());
        return app(Role::class)->where('name',$role)->first()->users()->get();
    }
    //1 3 4

}