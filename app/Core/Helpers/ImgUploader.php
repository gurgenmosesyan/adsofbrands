<?php

namespace App\Core\Helpers;

class ImgUploader
{
	protected static $includedHeadData = false;
	protected static $includedCropper = false;

	public static function uploader($module, $imageKey, $name, $value)
	{
		$config = config($module.'.images');
		$imageConf = $config[$imageKey];

		self::includeHeadData();
		if (isset($imageConf['cropper']) && $imageConf['cropper'] === true) {
			self::includeCropper($imageConf, $imageKey);
			$cropper = true;
		} else {
			$cropper = false;
		}

		if (empty($value)) {
			$src = '/core/images/img-default.png';
			$imgValue = '';
		} else {
			$src = $config['path'] . '/' . $value;
			$imgValue = 'same';
		}
		$helpText = self::getHelpTexts($module, $imageKey);
		?>
		<div id="<?php echo 'img-'.$imageKey; ?>" data-module="<?php echo $module.'.images.'.$imageKey; ?>" data-image_key="<?php echo $imageKey; ?>" class="img-uploader-box">
			<div class="img-thumbnail image-container">
				<img src="<?php echo $src; ?>" class="img-uploader-image img-agent-photo" />
			</div>
			<div class="img-uploader-tools">
				<a href="#" class="btn btn-default btn-xs uploader-upload-btn"><?php echo trans('core.img.uploader.upload_btn'); ?></a>
				<a href="#" class="btn btn-default btn-xs uploader-remove-btn"><?php echo trans('core.img.uploader.remove_btn'); ?></a>
				<?php if ($cropper) { ?>
					<a href="#" class="btn btn-default btn-xs uploader-crop-btn<?php echo empty($value) ? ' dn' : ''; ?>"><?php echo trans('core.img.uploader.crop_btn'); ?></a>
					<?php if (isset($imageConf['cropper_options']['rotate']) && !empty($imageConf['cropper_options']['rotate'])) { ?>
						<a href="#" class="crop-rotate-left btn btn-default btn-xs dn"><i class="icon-arrow-left"></i></a>
						<a href="#" class="crop-rotate-right btn btn-default btn-xs dn"><i class="icon-arrow-right"></i></a>
					<?php } ?>
					<a href="#" class="btn btn-green btn-xs crop-save-btn dn"><i class="icon-save"></i> <?php echo trans('core.img.uploader.crop_save_btn'); ?></a>
					<a href="#" class="btn btn-default btn-xs crop-cancel-btn dn"><?php echo trans('core.img.uploader.crop_cancel_btn'); ?></a>
				<?php }	if (!empty($helpText)) { ?><div class="img-uploader-help"><?php echo $helpText;?></div><?php } ?>
			</div>
			<input type="hidden" name="<?php echo $name;?>" value="<?php echo $imgValue; ?>" class="img-uploader-id" />
			<div class="form-error form-error-text" id="form-error-<?php echo $imageKey; ?>"></div>
			<?php
			if ($cropper && isset($imageConf['cropper_options']) && !empty($imageConf['cropper_options'])) {
				$options = $imageConf['cropper_options'];
				echo '<script type="text/javascript"> if (typeof $cropper == "undefined") { $cropper = {}; } $cropper["'.$imageKey.'"]={};';
				echo isset($options['ratio']) && !empty($options['ratio']) ? '$cropper["'.$imageKey.'"].ratio='.$options['ratio'].';' : '';
				echo isset($options['min_width']) && !empty($options['min_width']) ? '$cropper["'.$imageKey.'"].min_width='.$options['min_width'].';' : '';
				echo isset($options['min_height']) && !empty($options['min_height']) ? '$cropper["'.$imageKey.'"].min_height='.$options['min_height'].';' : '';
				echo '</script>';
			}
			?>
		</div>
	<?php
	}

	public static function getHelpTexts($module, $imageKey)
	{
		$options = config($module.'.images.'.$imageKey);
		$width = '';
		if (isset($options['width'])) {
			$width = trans('core.img.uploader.help.width', ['width' => $options['width']]);
		} else if (isset($options['min_width']) && isset($options['max_width'])) {
			$width = trans('core.img.uploader.help.width_interval', ['min_width' => $options['min_width'], 'max_width' => $options['max_width']]);
		} else if (isset($options['min_width'])) {
			$width = trans('core.img.uploader.help.min_width', ['min_width' => $options['min_width']]);
		} else if(isset($options['max_width'])){
			$width = trans('core.img.uploader.help.max_width', ['max_width' => $options['max_width']]);
		}
		$height = '';
		if (isset($options['height'])) {
			$height = trans('core.img.uploader.help.height', ['height' => $options['height']]);
		} else if (isset($options['min_height']) && isset($options['max_height'])) {
			$height = trans('core.img.uploader.help.height_interval', ['min_height' => $options['min_height'], 'max_height' => $options['max_height']]);
		} else if (isset($options['min_height'])) {
			$height = trans('core.img.uploader.help.min_height', ['min_height' => $options['min_height']]);
		} else if(isset($options['max_height'])){
			$height = trans('core.img.uploader.help.max_height', ['max_height' => $options['max_height']]);
		}
		$text = empty($width) && empty($height) ? '' : trans('core.img.uploader.help', ['width' => $width, 'height' => $height]).' ';
		$text = empty($options['extensions']) ? $text : $text.trans('core.img.uploader.help.extensions', ['extensions' => implode(', ', $options['extensions'])]);
		return $text;
	}

	public static function includeHeadData()
	{
		if (self::$includedHeadData === true) {
			return;
		}
		$head = Head::getInstance();
		$head->appendScript('/core/js/uploader.js');
		self::$includedHeadData = true;
	}

	public static function includeCropper()
	{
		if (self::$includedCropper === true) {
			return;
		}
		$head = Head::getInstance();
		$head->appendStyle('/assets/helix/core/css/cropper.min.css');
		$head->appendScript('/assets/helix/core/js/cropper.min.js');
		self::$includedCropper = true;
	}
}