<?php

namespace App\Core\Image\Exceptions;

use App\Core\Exceptions\Exception;

class InvalidMinHeightException extends Exception
{
	private $fileHeight = null;
	private $minHeight = null;

	public function setMinHeight($minHeight)
	{
		$this->minHeight = $minHeight;
	}

	public function getMinHeight()
	{
		return $this->minHeight;
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
