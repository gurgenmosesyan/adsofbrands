<?php

namespace App\Core\File;

use App\Core\File\Exceptions\FileNotFoundException;
use Auth;
use DB;
use Illuminate\Support\Facades\Request;
use Carbon\Carbon;
use App\Core\File\Exceptions\UnableCreateDirException;
use App\Core\File\Exceptions\InvalidFileExtensionException;
use App\Core\File\Exceptions\InvalidFileMaxSizeException;
use App\Core\Image\Exceptions\ImageNotFoundException;
use App\Core\Image\Exceptions\InvalidWidthException;
use App\Core\Image\Exceptions\InvalidMinWidthException;
use App\Core\Image\Exceptions\InvalidMaxWidthException;
use App\Core\Image\Exceptions\InvalidHeightException;
use App\Core\Image\Exceptions\InvalidMinHeightException;
use App\Core\Image\Exceptions\InvalidMaxHeightException;
use App\Core\Image\Image;

class Uploader
{
    const TYPE = 'file';

    protected $options = [
        'file_max_size' => 5,
        'extensions' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'zip', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'swf', 'bin'],
    ];

    public function getUploaderKey()
    {
        // @TODO: Fixme
        return 'default';
    }

    public function getUploaderType()
    {
        return self::TYPE;
    }

    /**
     * @return float
     */
    public function getFileMaxSize()
    {
        return $this->options['file_max_size'];
    }

    /**
     * @return array
     */
    public function getAllowedExtensions()
    {
        return $this->options['extensions'];
    }

    /**
     * @var array
     */
    protected static $filesList = [];

    /**
     * @param int $id
     * @param bool $checkUser
     * @param bool $findOrFail
     * @return \App\Core\File\UploadedFile
     * @throws \App\Core\File\Exceptions\FileNotFoundException
     */
    public static function getTempFile($id, $findOrFail = true, $checkUser = true)
    {
        if (isset(self::$filesList[$id])) {
            return self::$filesList[$id];
        }

        $fileData = DB::table('uploaded_files')->find($id);
        if (empty($fileData)) {
            if ($findOrFail) {
                throw new FileNotFoundException();
            }

            return;
        }
        $fileData = unserialize($fileData->file_data);

        $tempFile = new UploadedTempFile($fileData);

        /** @var \App\Core\File\UploadedFile $file */
        $file = self::$filesList[$id] = $tempFile;
        if ($checkUser && $file->getUserId() !== Auth::guard('admin')->user()->id) {
            if ($findOrFail) {
                throw new FileNotFoundException();
            }

            return;
        }

        return $file;
    }

    /**
     * @param string $imageKey
     * @return UploadedFile
     * @throws FileNotFoundException
     */
    public function getUploadedFile($imageKey)
    {
        $file = Request::file($imageKey);
        if ($file == null) {
            $e = new FileNotFoundException();
            $e->setErrorKey($imageKey);
            throw $e;
        }

        return new UploadedFile($file);
    }

    /**
     * @return string
     * @throws UnableCreateDirException
     */
    protected function getStoragePath()
    {
        $path = storage_path('app');
        $imagesStoragePath = $path.'/'.'uploaded_files';
        if (!file_exists($imagesStoragePath) && !mkdir($imagesStoragePath, 0777)) {
            throw new UnableCreateDirException('Unable create dir-'.$imagesStoragePath);
        }

        return $imagesStoragePath;
    }

    protected function createTempSubDir()
    {
        $tempDirSubFolder = rand(1, 7000);
        $tempDirSub = $this->getStoragePath().'/'.$tempDirSubFolder;
        if (!file_exists($tempDirSub) && !mkdir($tempDirSub, 0777)) {
            throw new UnableCreateDirException('Unable create dir-'.$tempDirSub);
        }

        return $tempDirSubFolder;
    }

    protected function validateFileSize(UploadedFile $file)
    {
        $fileMaxSize = $this->getFileMaxSize();
        if ($fileMaxSize === false) {
            return;
        }
        $fileMaxSize *= 1048576;
        $size = $file->getSize();
        if ($fileMaxSize < $size) {
            $e = new InvalidFileMaxSizeException('Invalid file size -'.$size);
            $e->setMaxSize($fileMaxSize);
            $e->setFileSize($size);
            throw $e;
        }
    }

    /**
     * @param string $image
     * @param string $module
     * @return int
     * @throws Exception
     * @throws ImageNotFoundException
     * @throws \Exception
     */
    public function saveToTemp($image = 'file', $module = null)
    {
        // FIXME: Check $_FILES['file']['error'] codes !!!

        $uploadedFile = $this->getUploadedFile($image);
        $tempSubDirFolder = $this->createTempSubDir();
        $moveToTempDirectory = $this->getStoragePath().'/'.$tempSubDirFolder;

        // @throws InvalidFileMaxSizeException
        $this->validateFileSize($uploadedFile);

        // @throws Media_ImgUploader_Exception_InvalidExtension, @throws Media_ImgUploader_Exception_InvalidImage
        $extension = $this->getFileExtension($uploadedFile, $module);

        $userId = Auth::guard('admin')->user()->id;
        $id = DB::table('uploaded_files')->insertGetId([
            'file_data' => '',
            'created_at' => new Carbon(),
            'uploader_key' => $this->getUploaderKey(),
            'uploader_type' => $this->getUploaderType(),
            'uploaded_by_id' => $userId,
        ]);

        $fileData = [
            'id' => $id,
            'client_original_name' => $uploadedFile->getClientOriginalName(),
            'client_size' => $uploadedFile->getClientSize(),
            'client_type' => $uploadedFile->getClientMimeType(),
            'created_at' => new Carbon(),
            'uploader_key' => $this->getUploaderKey(),
            'uploader_type' => $this->getUploaderType(),
            'uploaded_by_id' => $userId,
        ];
        $fileData['file_path'] = $uploadedFile->move($moveToTempDirectory, $id.'.'.$extension);

        DB::table('uploaded_files')
            ->where('id', $id)
            ->update([
                'file_data' => serialize($fileData),
                'file_path' => $tempSubDirFolder.'/'.$id.'.'.$extension,
            ]);

	    if ($module !== null && $image == 'image') {
		    $imgFile = new Image($moveToTempDirectory.'/'.$id.'.'.$extension);
		    $this->validateImageDimensions($imgFile, $module);
	    }

        return $fileData;
    }

	protected function validateImageDimensions(Image $image, $module)
	{
		$this->validateImageWidth($image, $module);
		$this->validateImageHeight($image, $module);
	}

	protected function validateImageWidth(Image $image, $module)
	{
		$options = config($module);
		$dimensions = $image->getDimensions();

		if (!empty($options['width'])) {
			if ($dimensions['width'] != $options['width']) {
				$ex = new InvalidWidthException();
				$ex->setWidth($options['width']);
				$ex->setFileWidth($dimensions['width']);
				throw $ex;
			}
			return;
		}
		if (!empty($options['min_width'])) {
			if ($dimensions['width'] < $options['min_width']) {
				$ex = new InvalidMinWidthException();
				$ex->setMinWidth($options['min_width']);
				$ex->setFileWidth($dimensions['width']);
				throw $ex;
			}
		}
		if (!empty($options['max_width'])) {
			if ($dimensions['width'] > $options['max_width']) {
				$ex = new InvalidMaxWidthException();
				$ex->setMaxWidth($options['max_width']);
				$ex->setFileWidth($dimensions['width']);
				throw $ex;
			}
		}
	}

	protected function validateImageHeight(Image $image, $module)
	{
		$options = config($module);
		$dimensions = $image->getDimensions();

		if (!empty($options['height'])) {
			if ($dimensions['height'] != $options['height']) {
				$ex = new InvalidHeightException();
				$ex->setHeight($options['height']);
				$ex->setFileHeight($dimensions['height']);
				throw $ex;
			}
			return;
		}
		if (!empty($options['min_height'])) {
			if ($dimensions['height'] < $options['min_height']) {
				$ex = new InvalidMinHeightException();
				$ex->setMinHeight($options['min_height']);
				$ex->setFileHeight($dimensions['height']);
				throw $ex;
			}
		}

		if (!empty($options['max_height'])) {
			if ($dimensions['height'] > $options['max_height']) {
				$ex = new InvalidMaxHeightException();
				$ex->setMaxHeight($options['max_height']);
				$ex->setFileHeight($dimensions['height']);
				throw $ex;
			}
		}
	}

    protected function getFileExtension(UploadedFile $file, $module = null)
    {
        $extension = $file->guessExtension();
        if (!$extension || !in_array($extension, $this->getAllowedExtensions())) {
            $e = new InvalidFileExtensionException();
            $e->setAllowedExtensions($this->getAllowedExtensions());
            throw $e;
        }

	    if ($module !== null) {
		    $config = config($module);
		    if (!empty($config['extensions']) && !in_array($extension, $config['extensions'])) {
			    $e = new InvalidFileExtensionException();
			    $e->setAllowedExtensions($config['extensions']);
			    throw $e;
		    }
	    }

        return $extension;
    }
}
