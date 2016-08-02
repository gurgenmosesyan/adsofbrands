<?php

namespace App\Core\File\Exceptions;

use App\Core\Exceptions\CatchableException;

class InvalidFileExtensionException extends CatchableException
{
	protected $errorKey = null;

	protected $allowedExtensions = null;

	public function getStatus()
	{
		return 'INVALID_DATA';
	}

	public function getErrors()
	{
		return [
			'file' => trans('uis_core.error.file_upload.invalid_extension', [
					'allowed_extensions' => implode(', ', $this->getAllowedExtensions()),
				]),
		];
	}

	public function setErrorKey($errorKey)
	{
		$this->errorKey = $errorKey;
	}

	public function getAllowedExtensions()
	{
		return $this->allowedExtensions;
	}

	public function setAllowedExtensions($allowedExtensions)
	{
		$this->allowedExtensions = $allowedExtensions;
	}
}
