<?php

namespace App\Http\Controllers\Core;

use App\Core\Image\Uploader;
use Illuminate\Http\Request;
use App\Core\File\Exceptions\FileNotFoundException;
use App\Core\File\Exceptions\InvalidFileExtensionException;
use App\Core\File\Exceptions\InvalidFileMaxSizeException;
use App\Core\Image\Exceptions\InvalidImageException;
use App\Core\Image\Exceptions\InvalidWidthException;
use App\Core\Image\Exceptions\InvalidMinWidthException;
use App\Core\Image\Exceptions\InvalidMaxWidthException;
use App\Core\Image\Exceptions\InvalidHeightException;
use App\Core\Image\Exceptions\InvalidMinHeightException;
use App\Core\Image\Exceptions\InvalidMaxHeightException;
use App\Core\File\Exceptions\UnableCreateDirException;
use App\Core\Image\Image;
use DB;

class ImageUploaderController extends BaseController
{
    /*public function upload()
    {
        $imageUploader = new Uploader();
        $uploadedFile = $imageUploader->saveToTemp('image');

        return $this->api(
            'OK',
            [
                'file_id' => $uploadedFile['id'],
            ]
        );
    }*/

	public function show(Request $request)
	{
		$fileId = $request->input('id');
		$tempData = DB::table('uploaded_files')->where('id', $fileId)->first();
		$file = storage_path('app/uploaded_files/'.$tempData->file_path);
		Image::outputImage($file);
	}

	public function upload(Request $request)
	{
		$module = $request->input('module');
		try {
			$imageUploader = new Uploader();
			$uploadedFile = $imageUploader->saveToTemp('image', $module);
            $uploadedFile['img_path'] = route('core_image_show', 'id='.$uploadedFile['id']);
			$status = 'OK';
			$data = $uploadedFile;
		} catch(FileNotFoundException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.not_found')];
		} catch(InvalidImageException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.invalid_image_type')];
		} catch (InvalidWidthException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.width', ['width' => $e->getWidth(), 'file_width' => $e->getFileWidth()])];
		} catch (InvalidMinWidthException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.min_width', ['min_width' => $e->getMinWidth(), 'file_width' => $e->getFileWidth()])];
		} catch (InvalidMaxWidthException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.max_width', ['max_width' => $e->getMaxWidth(), 'file_width' => $e->getFileWidth()])];
		} catch (InvalidHeightException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.height', ['height' => $e->getHeight(), 'file_width' => $e->getFileHeight()])];
		} catch (InvalidMinHeightException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.min_height', ['min_height' => $e->getMinHeight(), 'file_width' => $e->getFileHeight()])];
		} catch (InvalidMaxHeightException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.max_height', ['max_height' => $e->getMaxHeight(), 'file_width' => $e->getFileHeight()])];
		} catch (InvalidFileExtensionException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.extension', ['extensions' => implode(',', $e->getAllowedExtensions())])];
		} catch (InvalidFileMaxSizeException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.max_size', ['max_size' => $e->getMaxSize()])];
		} catch (UnableCreateDirException $e) {
			$status = 'INVALID_DATA';
			$data = ['error' => trans('core.img.uploader.error.unable_create_dir')];
		}
		echo json_encode(['status' => $status, 'data' => $data]);
		die();
	}
}