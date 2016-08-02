<?php

namespace App\Core\Image\Exceptions;

use App\Core\Exceptions\Exception;

class InvalidMaxWidthException extends Exception
{
	private $fileWidth = null;
	private $maxWidth = null;

	public function setMaxWidth( $maxWidth )
	{
		$this->maxWidth = $maxWidth;
	}

	public function getMaxWidth()
	{
		return $this->maxWidth;
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
