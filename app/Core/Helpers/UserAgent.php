<?php

namespace App\Core\Helpers;

class UserAgent
{	
	private $userAgent;
	
	public function __construct()
    {
		$this->userAgent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
	}

	public function isIPod()
    {
		return strpos($this->userAgent, 'iPod') !== false;
	}

	public function isIPad()
    {
		return strpos($this->userAgent, 'iPad') !== false;
	}

	public function isIPhone()
    {
		return strpos($this->userAgent, 'iPhone') !== false;
	}

	public function isAndroidMobile()
    {
		$ua = $this->userAgent;
		if (strpos($ua, 'Android') !== false && (strpos($ua, 'Mobile') !== false || (strpos($ua, 'Opera') !== false && strpos($ua, 'Mini') !== false))) {
			return true;
		}
		return false;
	}

	public function isWinPhone()
    {	
		$ua = $this->userAgent;
		if (stripos($ua, 'Windows Phone') !== false or stripos($ua, 'IEMobile') !== false or (stripos($ua, 'Windows Mobile') !== false and stripos($ua, 'Opera Mobi') !== false) or (stripos($ua, 'Windows') !== false and stripos($ua, 'Mobile') !== false)) {
			return true;
		}
		return false;
	}
}