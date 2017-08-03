<?php

namespace App\Transformers;


use App\Models\User;
use App\Repositories\CollegeRepository;
use App\Repositories\DepartmentRepository;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['roles'];

    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'gender' => $user->gender,
            'gender_str' => $user->gender ? '女' : '男',
            'college_id' => $user->college_id,
            'college' => app(CollegeRepository::class)->find($user->college_id, ['title']),
            'department_id' => $user->department_id,
            'department' => app(DepartmentRepository::class)->find($user->department_id, ['title']),
            'picture' => $user->picture,
            'is_super_admin' => $user->isSuperAdmin(),
            'created_at' => $user->created_at->toDateTimeString(),
            'updated_at' => $user->updated_at->toDateTimeString()
        ];
    }

    public function includeRoles(User $user)
    {
        $roles = $user->roles()->ancient()->get();
        return $this->collection($roles, new RoleTransformer());
    }
}
