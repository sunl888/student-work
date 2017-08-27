<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\RoleCreateRequest;
use App\Http\Requests\RoleUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Transformers\PermissionTransformer;
use App\Transformers\RoleTransformer;

class RoleController extends BaseController
{
    /**
     * 获取所有角色(不分页 用于添加用户时显示 除了超级管理员角色)
     *
     * @return \Dingo\Api\Http\Response
     */
    public function allRoles()
    {
        $roles = app(Role::class)->recent()->get();
        //->where('name','<>','super_admin')
        return $this->response()->collection($roles, new RoleTransformer());
    }

    /**
     * 角色列表
     * 分页显示
     * @return \Dingo\Api\Http\Response
     */
    public function lists()
    {
        $roles = Role::recent()
            ->paginate($this->perPage());
        return $this->response->paginator($roles, new RoleTransformer());
    }

    /**
     * 获取指定角色下面的权限
     *
     * @param  Role $role
     * @return \Dingo\Api\Http\Response
     */
    public function permissions(Role $role)
    {
        $permissions = $role->perms()->recent()->get();
        return $this->response->collection($permissions, new PermissionTransformer());
    }

    /**
     * 显示指定角色
     *
     * @param  Role $role
     * @return \Dingo\Api\Http\Response
     */
    public function show(Role $role)
    {
        $permissionIds = $role->perms->pluck('id');
        return $this->response->item($role, new RoleTransformer())
            ->addMeta('permission_ids', $permissionIds);
    }

    /**
     * 创建角色
     *
     * @param  RoleCreateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(RoleCreateRequest $request)
    {
        $data = $request->all();
        $role = app(Role::class)->create($request->all());
        if (!empty($data['permission_ids'])) {
            $permissionIds = app(Permission::class)->findOrfail($data['permission_ids'])->pluck('id');
            $role->attachPermissions($permissionIds);
        }
        return $this->response->noContent();
    }

    /**
     * 更新角色
     *
     * @param  Role $role
     * @param  RoleUpdateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(Role $role, RoleUpdateRequest $request)
    {
        $role->saveOrFail();
        $permissionIds = $request->get('permission_ids');
        if (!empty($permissionIds)) {
            $permissionIds = app(Permission::class)->findOrfail($permissionIds)->pluck('id');
            $role->savePermissions($permissionIds);
        }
        return $this->response->noContent();
    }

    /**
     * 删除角色
     *
     * @param  Role $role
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->response->noContent();
    }

}
