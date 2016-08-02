<?php

namespace App\Core\Image\Exceptions;

use App\Core\Exceptions\Exception;

class InvalidMinWidthException extends Exception
{
	private $fileWidth = null;
	private $minWidth = null;

	public function setMinWidth($minWidth)
	{
		$this->minWidth = $minWidth;
	}

	public function getMinWidth()
	{
		return $this->minWidth;
	}

	public function getFileWidth()
	{
		return $this->fileWidth;
	}

	public function setFileWidth($fileWidth)
	{
		$this->fileWidth = $fileWidth;
	}
}
