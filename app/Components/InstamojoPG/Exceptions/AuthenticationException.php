<?php

namespace App\Components\InstamojoPG\Exceptions;

class AuthenticationException extends InstamojoException
{
    public function __construct($errorMessage = null)
    {
        parent::__construct(401, 0, $errorMessage ?: 'Unauthorized');
    }
}
