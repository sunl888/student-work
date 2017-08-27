<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * 分页时每页显示多少数据
     *
     * @return int
     */
    public function perPage($default = null)
    {
        $maxPerPage = config('app.max_per_page');
        $perPage = (request('limit') ?: $default) ?: config('app.default_per_page');
        return (int)($perPage < $maxPerPage ? $perPage : $maxPerPage);
    }
}
