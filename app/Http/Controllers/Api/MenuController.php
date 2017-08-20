<?php

namespace App\Http\Controllers\Api;

use App\Repositories\MenuRepository;
use App\Transformers\MenuTransformer;

class MenuController extends BaseController
{
    public function menus()
    {
        $user = $this->guard()->user();
        return $this->response->array(app(MenuRepository::class)->getMenus($user));
    }
}
