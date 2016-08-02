<?php

namespace App\Core\Image;

use InvalidArgumentException;
use UnexpectedValueException;

class Image
{
	/**
	 * Watermark positions
	 */
	const POS_TOP_LEFT 		= 'top_left';
	const POS_TOP_RIGHT 	= 'top_right';
	const POS_BOTTOM_LEFT 	= 'bottom_left';
	const POS_BOTTOM_RIGHT 	= 'bottom_right';
	const POS_MIDDLE_CENTER = 'middle_center';

    /**
     * Path to image file.
     *
     * @var string
     */
    protected $file = null;

    /**
     * @var resource
     */
    protected $image = null;

    /**
     * @var array
     */
    protected $info = null;

	protected static $imageExtensionToType = [
		'jpeg' => 'image/jpeg',
		'jpg'  => 'image/jpeg',
		'png'  => 'image/png',
	];

    /**
     * @param string $file
     * @throws \InvalidArgumentException
     */
    public function __construct($file)
    {
        if (!file_exists($file)) {
            throw new InvalidArgumentException('Unable open image file - '.$file);
        }
        $this->file = $file;
        $info = getimagesize($file);
        $this->info = [
            'width' => $info[0],
            'height' => $info[1],
            'bits' => $info['bits'],
            'mime' => $info['mime'],
        ];
        $this->image = $this->create();
        if (!$this->image) {
            throw new InvalidArgumentException('Unable create image from file - '.$file);
        }
    }

    /**
     * @return resource An image resource identifier on success, false on errors.
     * @param string $file
     * @throws \InvalidArgumentException
     */
    protected function create($file = null)
    {
        if ($file !== null) {
            $info = getimagesize($file);
            $mime = $info['mime'];
        } else {
            $file = $this->file;
            $mime = $this->info['mime'];
        }

        switch ($mime) {
            case 'image/jpeg':
                return imagecreatefromjpeg($file);
            case 'image/png':
                return imagecreatefrompng($file);
            case 'image/gif':
                return imagecreatefromgif($file);
            default:
                throw new InvalidArgumentException('Do not support '.$mime.' type of image.');
        }
    }

    /**
     * @return array
     */
    public function getDimensions()
    {
        return [
            'width' => $this->info['width'],
            'height' => $this->info['height'],
        ];
    }

    /**
     * Save image to $file.
     *
     * @param $file
     * @param int $quality
     */
    public function save($file, $quality = 90)
    {
        if (!is_resource($this->image)) {
            throw new UnexpectedValueException('this->image is not resource, file-'.$this->file);
        }

        imagealphablending($this->image, false);
        imagesavealpha($this->image, true);

        $extension = strtolower(pathinfo($file)['extension']);
        if ($extension == 'jpeg' || $extension == 'jpg') {
            imagejpeg($this->image, $file, $quality);
        } elseif ($extension == 'png') {
            imagepng($this->image, $file, 0);
        } elseif ($extension == 'gif') {
            imagegif($this->image, $file);
        } else {
            throw new UnexpectedValueException('Invalid image extension - '.$extension.', file-'.$this->file);
        }
        imagedestroy($this->image);
    }

    /**
     * Output image.
     */
    public function output()
    {
        if (!is_resource($this->image)) {
            throw new UnexpectedValueException('this->image is not resource, file-'.$this->file);
        }

        $extension = strtolower(pathinfo($this->file)['extension']);
        if ($extension == 'jpeg' || $extension == 'jpg') {
            header('Content-type: image/jpg');
            imagejpeg($this->image);
        } elseif ($extension == 'png') {
            header('Content-type: image/png');
            imagepng($this->image);
        } elseif ($extension == 'gif') {
            header('Content-type: image/gif');
            imagegif($this->image);
        } else {
            throw new UnexpectedValueException('Invalid image extension - '.$extension.', file-'.$this->file);
        }
        imagedestroy($this->image);
    }

    /**
     * @throws \InvalidArgumentException
     */
    public function scaleImage($width, $height, $revers = false)
    {
        if (!$this->info['width'] || !$this->info['height']) {
            throw new UnexpectedValueException('Invalid image with and  height '.print_r($this->info, true));
        }

        $newDimension = $this->calculateScaledImageNewDimension($width, $height, $revers);
        if ($newDimension === false) {
            return false;
        }
        $oldImage = $this->image;
        $this->image = imagecreatetruecolor($newDimension['width'], $newDimension['height']);

        imagecopyresampled($this->image, $oldImage, 0, 0, 0, 0, $newDimension['width'], $newDimension['height'], $this->info['width'], $this->info['height']);
        imagedestroy($oldImage);

        $this->info['width'] = $newDimension['width'];
        $this->info['height'] = $newDimension['height'];

        return true;
    }

    protected function calculateScaledImageNewDimension($width, $height, $revers)
    {
        $height = $height === null ? 1000000000 : $height;
        $width = $width === null ? 1000000000 : $width;
        $func = $revers ? 'max' : 'min';

        $widthScale = $width / $this->info['width'];
        $heightScale = $height / $this->info['height'];
        $scale = $func($widthScale, $heightScale);

        if ($widthScale > $heightScale) {
            $newWidth = $width;
            $newHeight = intval(ceil($this->info['height'] * $scale));
        } else {
            $newWidth = intval(($this->info['width'] * $scale));
            $newHeight = $height;
        }

        if ($scale >= 1) {
            return false;
        }

        return ['width' => $newWidth, 'height' => $newHeight];
    }

    /**
     * @param int $width
     * @param int $height
     */
    public function cut($width, $height)
    {
        $this->scaleImage($width, $height, true);
        if ($width < $this->info['width']) {
            $this->cutVertical($width);
        } else {
            if ($height < $this->info['height']) {
                $this->cutHorizontal($height);
            }
        }
    }

    public function cutVertical($width)
    {
        $x = ($this->info['width'] - $width) / 2;
        $cropOptions = [
            'x' => $x,
            'y' => 0,
            'width' => $width,
            'height' => $this->info['height'],
        ];
        $this->image = imagecrop($this->image, $cropOptions);
        $this->info['width'] = $width;
    }

    public function cutHorizontal($height)
    {
        $y = ($this->info['height'] - $height) / 2;
        $cropOptions = [
            'x' => 0,
            'y' => $y,
            'width' => $this->info['width'],
            'height' => $height,
        ];
        $this->image = imagecrop($this->image, $cropOptions);
        $this->info['height'] = $height;
    }

	public function watermarkImage($overlayFile, $margin = 0, $position = Image::POS_BOTTOM_RIGHT)
	{
		if (is_resource($overlayFile)) {
			$watermark = $overlayFile;
		} else {
			$watermark = $this->create($overlayFile);
		}
		$watermark_width  = imagesx($watermark);
		$watermark_height = imagesy($watermark);

		switch($position) {
			case Image::POS_TOP_LEFT:
				$watermark_pos_x = $margin;
				$watermark_pos_y = $margin;
				break;
			case Image::POS_TOP_RIGHT:
				$watermark_pos_x = $this->info['width'] - $watermark_width - $margin;
				$watermark_pos_y = $margin;
				break;
			case Image::POS_MIDDLE_CENTER:
				$watermark_pos_x = ( $this->info['width'] - $watermark_width )/ 2;
				$watermark_pos_y = ( $this->info['height'] - $watermark_height )/ 2;
				break;
			case Image::POS_BOTTOM_LEFT:
				$watermark_pos_x = $margin;
				$watermark_pos_y = $this->info['height'] - $watermark_height - $margin;
				break;
			case Image::POS_BOTTOM_RIGHT:
				$watermark_pos_x = $this->info['width'] - $watermark_width - $margin;
				$watermark_pos_y = $this->info['height'] - $watermark_height - $margin;
				break;
			default:
				throw new InvalidArgumentException('Do not support '.$position.' type of position');
				break;
		}
		imagecopy($this->image, $watermark, $watermark_pos_x, $watermark_pos_y, 0, 0, $watermark_width, $watermark_height);
		imagedestroy($watermark);
	}

    public function rotate($degree, $color = 'FFFFFF')
    {
        //$rgb = $this->html2rgb($color);
        //$this->image = imagerotate($this->image, $degree, imagecolorallocate($this->image, $rgb[0], $rgb[1], $rgb[2]));
        $this->image = imagerotate($this->image, $degree, imagecolorallocatealpha($this->image, 0, 0, 0, 127), 1);
        /*imagealphablending($this->image, false);
        imagesavealpha($this->image, true);*/

        $this->info['width'] = imagesx($this->image);
        $this->info['height'] = imagesy($this->image);
    }

	public static function outputImage($file)
	{
		$imageExtension = strtolower(pathinfo($file)['extension']);
		if (!isset(self::$imageExtensionToType[$imageExtension])) {
			throw new InvalidArgumentException("Image type not found - {$imageExtension}");
		}
		$imageType = self::$imageExtensionToType[$imageExtension];
		header('Content-Type:'.$imageType);
		header('Content-Length: ' . filesize($file));
		readfile($file);
		die();

	}

    protected function html2rgb($color)
    {
        if ($color[0] == '#') {
            $color = substr($color, 1);
        }

        if (strlen($color) == 6) {
            list($r, $g, $b) = [$color[0].$color[1], $color[2].$color[3], $color[4].$color[5]];
        } elseif (strlen($color) == 3) {
            list($r, $g, $b) = [$color[0].$color[0], $color[1].$color[1], $color[2].$color[2]];
        } else {
            return false;
        }

        $r = hexdec($r);
        $g = hexdec($g);
        $b = hexdec($b);

        return [$r, $g, $b];
    }
}
