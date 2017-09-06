<?php

namespace App\Exceptions;

use Illuminate\Validation\UnauthorizedException;

class LoginFailed extends UnauthorizedException
{

    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
