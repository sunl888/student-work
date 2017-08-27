<?php


namespace App\Http\Controllers\Api;

use App\Http\Requests\PermissionCreateRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Models\Permission;
use App\Transformers\PermissionTransformer;

class PermissionsController extends BaseController
{
    /**
     * 获取指定权限信息
     *
     * @param  Permission $permission
     * @return \Dingo\Api\Http\Response
     */
    public function show(Permission $permission)
    {
        return $this->response->item($permission, new PermissionTransformer());
    }

    /**
     * 获取所有权限(不分页 用于创建角色时显示)
     *
     * @return mixed
     */
    public function allPermissions()
    {
        $permissions = Permission::allPermission();
        return $this->response->collection($permissions, new PermissionTransformer());
    }

    /**
     * 创建权限
     *
     * @param  PermissionCreateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function store(PermissionCreateRequest $request)
    {
        $data = $request->all();
        app(Permission::class)->create($data);
        return $this->response->noContent();
    }

    /**
     * 更新权限
     *
     * @param  Permission $permission
     * @param  PermissionUpdateRequest $request
     * @return \Dingo\Api\Http\Response
     */
    public function update(Permission $permission, PermissionUpdateRequest $request)
    {
        $data = $request->all();
        $permission->update($data);
        return $this->response->noContent();
    }

    /**
     * 删除指定权限
     *
     * @param  Permission $permission
     * @return \Dingo\Api\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        return $this->response->noContent();
    }
}
