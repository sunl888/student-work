<?php

namespace App\Models;

use Zizaco\Entrust\Contracts\EntrustRoleInterface;
use Zizaco\Entrust\Traits\EntrustRoleTrait;

class Role extends BaseModel implements EntrustRoleInterface
{
    use EntrustRoleTrait;

    /**
     * 角色用户
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * 角色菜单
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function menus()
    {
        return $this->belongsToMany(Menu::class);
    }


}
