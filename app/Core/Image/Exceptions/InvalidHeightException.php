<?php

namespace App\Core\Image\Exceptions;

use App\Core\Exceptions\Exception;

class InvalidHeightException extends Exception
{
	private $fileHeight = null;
	private $Height = null;

	public function setHeight($Height)
	{
		$this->Height = $Height;
	}

	public function getHeight()
	{
		return $this->Height;
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
