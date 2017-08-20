<?php
/**
 * Created by PhpStorm.
 * User: Sunlong
 * Date: 2017/7/29
 * Time: 15:28
 */

namespace App\Repositories;

use App\models\Menu;
use App\Models\Role;
use Illuminate\Support\Collection;

class MenuRepository extends Repository
{

    public function __construct()
    {
        $this->model = app(Menu::class);
    }

    public function getMenus($user)
    {
        // todo 这里如果用户属于多个角色就会出现权限错乱的问题(这是由于角色的权限写死的原因。。)
        $roles = $user->roles()->get();
        $menus = new Collection();
        foreach ($roles as $role){
            $menus = $menus->merge($role->menus()->get()->toArray());
        }
        $menus = $menus->toArray();
        $new_menus = [];
        foreach ($menus as $menu) {
            if($menu['parent_id']){
                $new_menus[$menu['parent_id']]['child'][] = $menu;
            }else{
                $new_menus[$menu['id']] = $menu;
            }
        }
        return $new_menus;
    }

}