<?php

namespace App\Core\Image\Exceptions;

use App\Core\Exceptions\Exception;

class InvalidWidthException extends Exception
{
	private $fileWidth = null;
	private $width = null;

	public function setWidth($width)
	{
		$this->width = $width;
	}

	public function getWidth()
	{
		return $this->width;
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
