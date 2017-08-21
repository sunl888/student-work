<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MenuRepository;

class MenuController extends BaseController
{
    /**
     * 获取菜单
     * @return mixed
     */
    public function menus()
    {
        $user = $this->guard()->user();
        return $this->response->array(app(MenuRepository::class)->getMenus($user));
    }
}
