<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class LoginFailed extends HttpException
{

    public function __construct($message, $statusCode = 403)
    {
        parent::__construct($statusCode, $message, null, [], $statusCode);
    }
}
