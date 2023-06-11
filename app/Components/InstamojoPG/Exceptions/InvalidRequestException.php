<?php

namespace App\Components\InstamojoPG\Exceptions;

class InvalidRequestException extends InstamojoException
{
    public function __construct($errorMessage)
    {
        parent::__construct(null, null, $errorMessage);
    }
}
