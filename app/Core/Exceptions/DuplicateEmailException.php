<?php

namespace App\Core\Exceptions;

use Exception;

class DuplicateEmailException extends Exception
{
    public function getError()
    {
        return 'core.base.error.duplicate_email';
    }
}