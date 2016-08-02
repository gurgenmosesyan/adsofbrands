<?php

namespace App\Core\Image\Exceptions;

use App\Core\Exceptions\NotFoundException;

class InvalidImageException extends NotFoundException
{
    protected $errorKey = null;

    public function setErrorKey($errorKey)
    {
        $this->errorKey = $errorKey;
    }

	public function getErrorKey()
	{
		return $this->errorKey;
	}
}
