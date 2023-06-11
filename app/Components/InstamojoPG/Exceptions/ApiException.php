<?php

namespace App\Components\InstamojoPG\Exceptions;

class ApiException extends InstamojoException
{
    public function __construct($httpErrorCode, $errorNumber, $errorMessage)
    {
        parent::__construct($httpErrorCode, $errorNumber, $errorMessage);
    }
}
