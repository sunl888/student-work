<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TaskProgress;
use App\Models\User;
use App\Service\ValidatePermission;
use Auth;
use Dingo\Api\Routing\Helpers;

class BaseController extends Controller
{
    use Helpers, ValidatePermission;

    public function getUsers($userIds)
    {
        if ($userIds instanceof Model) {
            $userIds = explode(',', $userIds->user_id);
        } else {
            $userIds = explode(',', $userIds);
        }
        $tmp = '';
        if (array_first($userIds) != null) {
            if (strtolower(array_first($userIds)) == TaskProgress::$personnelSign) {
                return '全体人员';
            } elseif (count($userIds) == 1) {
                $user = User::find(array_first($userIds));
                return $user->name;
            } elseif (count($userIds) > 1) {
                $users = User::whereIn('id', $userIds)->get();
                foreach ($users as $user) {
                    $tmp .= $user->name . ',';
                }
                return $tmp;
            }
        } else {
            return null;
        }
    }

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
