<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Core\Helpers\Head;
use App\Core\Helpers\JsTrans;
use App\Core\Language\Language;
use App\Core\Image\Uploader;
use Validator;
use DB;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		view()->share('head', Head::getInstance());
		view()->share('jsTrans', new JsTrans());

        Validator::extend('ml', function($attribute, $value, $parameters, $validator) {
            if (!is_array($value)) {
                return false;
            }
            $languages = Language::all()->keyBy('id');
            foreach ($value as $lngId => $val) {
                if (!isset($languages[$lngId])) {
                    return false;
                }
            }
            return true;
        });

        Validator::extend('core_image', function($attribute, $value, $parameters, $validator) {
            if (empty($value) || $value === 'same') {
                return true;
            } else {
                $tempFile = Uploader::getTempImage($value, false, true);
                if (empty($tempFile)) {
                    return false;
                }
                return true;
            }
        });
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register()
	{
		//
	}
}
