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

}
