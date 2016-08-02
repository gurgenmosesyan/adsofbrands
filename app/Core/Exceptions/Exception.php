<?php

namespace App\Core\Exceptions;

class Exception extends \Exception
{
    public function getMessageData()
    {
        return;
    }

    public function getHttpHeaders()
    {
        return;
    }

    public function getStatus()
    {
        return;
    }

    public function getHttpStatusCode()
    {
        return;
    }

    public function useDefault()
    {
        return true;
    }

    public function logException()
    {
        return true;
    }

    public function getValidationErrors()
    {
    }

    public function getErrors()
    {
        return;
    }
}
