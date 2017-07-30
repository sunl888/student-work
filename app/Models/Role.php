<?php

namespace App\Models;

use Zizaco\Entrust\Contracts\EntrustRoleInterface;
use Zizaco\Entrust\Traits\EntrustRoleTrait;

class Role extends BaseModel implements EntrustRoleInterface
{
    use EntrustRoleTrait;
}
