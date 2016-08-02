<?php

namespace App\Core\Image\Exceptions;

use App\Core\Exceptions\Exception;

class InvalidMaxHeightException extends Exception
{
	private $fileHeight = null;
	private $maxHeight = null;

	public function setMaxHeight( $maxHeight )
	{
		$this->maxHeight = $maxHeight;
	}

	public function getMaxHeight()
	{
		return $this->maxHeight;
	}

	public function getFileHeight()
	{
		return $this->fileHeight;
	}

	public function setFileHeight($fileHeight)
	{
		$this->fileHeight = $fileHeight;
	}
}
