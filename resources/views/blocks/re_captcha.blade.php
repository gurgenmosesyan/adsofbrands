<?php $conf = config('main.re_captcha'); ?>
<div id="re-captcha">
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <div class="g-recaptcha" data-sitekey="{!! $conf['site_key'] !!}" data-callback="reCaptchaCallback"></div>
    <div id="form-error-re_captcha" class="form-error"></div>
</div>