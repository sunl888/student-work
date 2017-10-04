<?php

namespace App\Service;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2017/8/13
 * Time: 14:21
 */
trait ValidatePermission
{
    protected function allowCreateTask()
    {
        return $this->validatePermission('admin.create_task');
    }

    protected function validatePermission($permissions)
    {
        if (!$this->guard()->check() || !$this->guard()->user()->may($permissions)) {
            throw new AuthorizationException();
        }
        return true;
    }

    protected function allowAuditTask()
    {
        return $this->validatePermission('admin.audit_task');
    }

    protected function allowRestoreTask()
    {
        return $this->allowDeleteTask();
    }

    protected function allowDeleteTask()
    {
        return $this->validatePermission('admin.delete_task');
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

    // 是否显示任务详情（各个学院的任务完成情况）
    protected function allowSearchTaskDetail()
    {
        return Auth::user()->isSuperAdmin();
    }
}
