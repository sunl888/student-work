<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Service\ValidatePermission;
use Auth;
use Dingo\Api\Routing\Helpers;

class BaseController extends Controller
{
    use Helpers, ValidatePermission;

    /**
     * Get the guard to be used during authentication.
     * 用户组（在 Laravel5.3 中对于多组用户有更加完善的支持，可以有多组用户系统，比方说前台、后台各有一组用户系统。）
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web');
    }

}
