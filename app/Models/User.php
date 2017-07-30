<?php

namespace App\Models;

use Illuminate\Auth\Access\Gate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends BaseModel implements AuthenticatableContract,AuthorizableContract,CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable;
    use EntrustUserTrait {
        EntrustUserTrait::can as may;
        Authorizable::can insteadof EntrustUserTrait;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','gender'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }

    public function authorize($ability, $arguments = [])
    {
        return app(Gate::class)->forUser($this)->authorize($ability, $arguments);
    }
}

