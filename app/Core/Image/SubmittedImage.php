<?php

namespace App\Core\Image;

use App\Core\File\SubmittedFile;
use App\Core\File\UploadedTempFile;

class SubmittedImage extends SubmittedFile
{
    /**
     * @var \App\Core\File\UploadedTempFile
     */
    protected $tempImage = null;

    public function __construct($imageType = null)
    {
        $this->setFileType($imageType);
    }

    /**
     * @param string $imageType
     */
    public function setImageType($imageType)
    {
        $this->setFileType($imageType);
    }

    /**
     * @param UploadedTempFile $tempImage
     */
    public function setTempImage(UploadedTempFile $tempImage)
    {
        $this->setTempFile($tempImage);
    }

    /**
     * @return UploadedTempFile
     */
    public function getTempImage()
    {
        return $this->getTempFile();
    }
}
