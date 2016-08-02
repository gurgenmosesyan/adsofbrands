<?php

namespace App\Image;

use Intervention\Image\ImageManagerStatic as ImageManager;

class Image
{
    public static function show($imageId, $conf)
    {
        $conf = explode('.', $conf);
        $imageProportion = array_pop($conf);
        $conf = config('images.'.implode('.', $conf));

        $imageOptions = $conf[$imageProportion];
        if (isset($imageOptions['crop'])) {
            $image = self::crop($conf['path'].'/'.$imageId, $imageOptions['crop'], $imageOptions['width'], $imageOptions['height']);
        } else {
            $image = self::resize($conf['path'].'/'.$imageId, $imageOptions['width'], $imageOptions['height']);
        }
        return $image;
    }

    public static function resize($filename, $width = null, $height = null)
    {
        $info = pathinfo($filename);
        $extension = $info['extension'];

        $directory = $info['dirname'].'/'.$info['filename'];
        $imgFilePath = $directory.'/'.$width.'x'.$height.'.'.$extension;

        if (!file_exists(public_path($imgFilePath))) {
            if (!file_exists(public_path($filename)) || !is_file(public_path($filename))) {
                return false;
            }
            if (!file_exists(public_path($directory))) {
                $success = mkdir(public_path($directory), 0775);
                if (!$success) {
                    return false;
                }
            }
            $image = ImageManager::make(public_path($filename));
            if ($width !== null) {
                $image->resize($width, null, function($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $image->resize(null, $height, function($constraint) {
                    $constraint->aspectRatio();
                });
            }
            $image->save(public_path($imgFilePath));
        }
        return $imgFilePath;
    }

    public static function crop($filename, $mode = 'center', $width = null, $height = null)
    {
        $info = pathinfo($filename);
        $extension = $info['extension'];

        $directory = $info['dirname'].'/'.$info['filename'];
        $imgFilePath = $directory.'/'.$width.'x'.$height.'c-'.$mode.'.'.$extension;

        if (!file_exists(public_path($imgFilePath))) {
            if (!file_exists(public_path($filename)) || !is_file(public_path($filename))) {
                return false;
            }
            if (!file_exists(public_path($directory))) {
                $success = mkdir(public_path($directory), 0775);
                if (!$success) {
                    return false;
                }
            }
            $image = ImageManager::make(public_path($filename));
            $imageWidth = $image->getWidth();
            $imageHeight = $image->getHeight();

            if (($imageWidth / $imageHeight) > ($width / $height)) {
                $image->resize(null, $height, function($constraint) {
                    $constraint->aspectRatio();
                });
                $imageWidth = $image->getWidth();
                $x = abs(intval(($imageWidth - $width) / 2));
                $image->crop($width, $height, $x, 0);
            } else if (($imageWidth / $imageHeight) < ($width / $height)) {
                $image->resize($width, null, function($constraint) {
                    $constraint->aspectRatio();
                });
                $imageHeight = $image->getHeight();
                $y = abs(intval(($imageHeight - $height) / 2));
                $image->crop($width, $height, 0, $y);
            } else {
                $image->resize($width, $height);
            }
            $image->save(public_path($imgFilePath));
        }
        return $imgFilePath;
    }

    public static function deleteImage($imageId, $conf = null)
    {
        self::clearCache($imageId, $conf);
        if ($conf===null) {
            unlink(UIS_IMAGE_DIR.$imageId);
        } else {
            $conf = explode('.', $conf);
            //array_pop($conf);
            $conf = Core_Config::conf($conf);
            self::deleteImage($conf['path'].$imageId);
        }
    }

    public static function clearCache($imageId, $conf = null)
    {
        if ($conf===null) {
            $info = pathinfo($imageId);
            UIS_File::deleteDirFiles(UIS_IMAGE_DIR.$info['dirname'].'/'.$info['filename'], true, true);
        } else {
            $conf = explode('.', $conf);
            array_pop($conf);
            $conf = Core_Config::conf($conf);
            return self::clearCache($conf['path'].$imageId);
        }
    }

    protected static function createDirs ($root, $path)
    {
        $root = rtrim($root, DIRECTORY_SEPARATOR);
        $subDirs = explode(DIRECTORY_SEPARATOR, trim($path, DIRECTORY_SEPARATOR));
        if ($subDirs == null) {
            return true;
        }
        $oldUmask = umask(0);
        $currDir = $root;
        foreach ($subDirs as $dir) {
            $currDir = $currDir . DIRECTORY_SEPARATOR . $dir;
            if (!file_exists($currDir)) {
                $success = mkdir($currDir, UIS_FILE_PERMISSIONS);
                if(!$success){
                    umask($oldUmask);
                    return false;
                }
            }
        }
        umask($oldUmask);
        return true;

    }
}