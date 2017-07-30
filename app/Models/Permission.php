<?php

namespace App\Models;


use Zizaco\Entrust\Contracts\EntrustPermissionInterface;
use Zizaco\Entrust\Traits\EntrustPermissionTrait;

class Permission extends BaseModel implements EntrustPermissionInterface
{
    use EntrustPermissionTrait;
}
