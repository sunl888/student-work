<?php

namespace App\Http\Controllers\Api;

use App\Service\ValidatePermission;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Auth;

class BaseController extends Controller
{
    use Helpers,ValidatePermission;

    public function perPage($default = null)
    {
        $maxPerPage = config('app.max_per_page');
        $perPage = (request('per_page') ?: $default) ?: config('app.default_per_page');
        return (int)($perPage < $maxPerPage ? $perPage : $maxPerPage);
    }
}
