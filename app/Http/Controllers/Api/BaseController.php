<?php

namespace App\Http\Controllers\Api;

use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Auth;

class BaseController extends Controller
{
    use Helpers;

    /**
     * Get the guard to be used during authentication.
     * 用户组（在 Laravel5.3 中对于多组用户有更加完善的支持，可以有多组用户系统，比方说前台、后台各有一组用户系统。）
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

    protected function validatePermission($permissions)
    {
        if (!$this->guard()->check() || !$this->guard()->user()->may($permissions)) {
            throw new AuthorizationException();
        }
        return true;
    }

    protected function allowCreateTask()
    {
        return $this->validatePermission('admin.create_task');
    }

    protected function allowAuditTask()
    {
        return $this->validatePermission('admin.audit_task');
    }

    protected function allowDeleteTask()
    {
        return $this->validatePermission('admin.delete_task');
    }

    protected function allowRestoreTask()
    {
        return $this->allowDeleteTask();
    }

    protected function allowAllotTask()
    {
        return $this->validatePermission('admin.add_person_liable');
    }

    protected function allowSubmitTask()
    {
        return $this->validatePermission('admin.submit_task');
    }

    protected function allowScore()
    {
        return $this->validatePermission('admin.quality_assessment');
    }

    protected function allowUpdateTask()
    {
        return $this->validatePermission('admin.edit_task');
    }
}
