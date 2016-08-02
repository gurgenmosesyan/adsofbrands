<?php

namespace App\Core\Exceptions;

use Exception;

class RequestTokenMismatchException extends Exception
{
    public function getStatus()
    {
        return 'FORBIDDEN';
    }
}