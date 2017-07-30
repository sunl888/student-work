<?php


namespace App\Http\Controllers\Api;

use App\Transformers\UserTransformer;

class UsersController extends BaseController
{
    public function me()
    {
        return $this->response->item($this->guard()->user(), new UserTransformer());
    }


}
