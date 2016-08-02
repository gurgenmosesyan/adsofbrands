<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
	//public static $valInstance = null;

	public function authorize()
	{
		return true;
	}

	/*public function getValInstance()
	{
		if (self::$valInstance === null) {
			self::$valInstance = $this->getValidatorInstance();
		}
		return self::$valInstance;
	}*/

	public function response(array $errors)
	{
		if ($this->ajax() || $this->wantsJson()) {
			return new JsonResponse(['status' => 'INVALID_DATA', 'errors' => $errors]);
		}

		return $this->redirector->to($this->getRedirectUrl())
			->withInput($this->except($this->dontFlash))
			->withErrors($errors, $this->errorBag);
	}

	public function messages()
	{
		return [
			'required' => trans('admin.base.field.required'),
			'required_if' => trans('admin.base.field.required'),
			'required_with' => trans('admin.base.field.required'),
			'unique' => trans('admin.base.field.duplicate'),
			'max*' => trans('admin.base.field.max_length', ['max' => ':max']),
			'min*' => trans('admin.base.field.min_length', ['min' => ':min']),
            'ml' => trans('admin.error.ml'),
		];
	}

	/*public function validate()
	{
		$instance = $this->getValInstance();

		$this->processed();

		if ($instance->valid()) {
			$this->success();
		} else {
			$this->failed();
		}

		if (!$instance->passes()) {
			$this->failedValidation($instance);
		}
	}*/

	protected function processed() {}

	protected function success() {}

	protected function failed() {}
}
