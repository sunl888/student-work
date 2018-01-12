<?php

namespace App\Models;

use App\Models\Traits\Listable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Access\Gate;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\Notifiable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends BaseModel implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, Notifiable, Listable;
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
        'name', 'email', 'password', 'nickname', 'phone', 'gender', 'college_id', 'department_id', 'picture'
    ];

    protected static $allowSearchFields = ['name', 'gender', 'role_id', 'nickname', 'college_id'];
    protected static $allowSortFields = ['name', 'nickname', 'gender', 'college_id', 'department_id'];

    protected $casts = [
        'gender' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'deleted_at'
    ];


    public function isSuperAdmin()
    {
        return $this->hasRole('super_admin');
    }
    public function isNotSuperAdmin()
    {
        return $this->hasRole(['teacher','college',]);
    }

    public function isCollege()
    {
        return $this->hasRole(['college']);
    }

    public function scopeByCollege($query,$college)
    {
        return $query->where('college_id',$college);
    }

    public function isTeacher()
    {
        return $this->hasRole(['teacher']);
    }
    /*public function scopeByNotSuperAdmin($query)
    {$this->isSuperAdmin();
        return $query->isNotSuperAdmin();
    }*/

    /**
     * 用户角色
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function authorize($ability, $arguments = [])
    {
        try {
            return app(Gate::class)->forUser($this)->authorize($ability, $arguments);
        } catch (AuthorizationException $e) {
        }
    }

    public function college()
    {
        return $this->hasOne(College::class, 'id', 'college_id');
    }
}

