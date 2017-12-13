<?php

namespace App\Transformers;

use App\Models\User;
use App\Repositories\CollegeRepository;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['roles'];

    public function transform(?User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'phone' => $user->phone,
            'email' => $user->email,
            'gender' => $user->gender,
            'role_id' => $user->role_id,
            'picture' => $user->picture,
            'nickname' => $user->nickname,
            'role_name' => $user->role_name,
            'college_id' => (int)$user->college_id,
            'role_dispname' => $user->role_disp_name,
            'is_super_admin' => $user->isSuperAdmin(),
            'gender_str' => $user->gender ? '女' : '男',
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString(),
            'college' => app(CollegeRepository::class)->find($user->college_id, ['title']),
        ];
    }

    public function includeRoles(User $user)
    {
        $roles = $user->roles()->ancient()->get();
        return $this->collection($roles, new RoleTransformer());
    }
}
