<?php
/**
 *
 */

class Helper {

	static function Get($val) {
		if (isset($_GET[$val]) && $_GET[$val] != '') {
			return $_GET[$val];
		} else {
			return false;
		}
	}

	static function Post($val) {
		if (isset($_POST[$val]) && $_POST[$val] != '') {
			return $_POST[$val];
		} else {
			return false;
		}
	}

	static function Request($val) {
		if (isset($_REQUEST[$val]) && $_REQUEST[$val] != '') {
			return $_REQUEST[$val];
		} else {
			return false;
		}
	}

	static function Cookie($val) {
		if (isset($_COOKIE[$val]) && $_COOKIE[$val] != '') {
			return $_COOKIE[$val];
		} else {
			return false;
		}
	}

	static function Cookie_Set($key, $val) {
		if (isset($_COOKIE[$key])) {
			$_COOKIE[$key] = $val;
		} else {
			return false;
		}
	}

	static function Globals($val) {
		if (isset($GLOBALS[$val]) && $GLOBALS[$val] != '') {
			return $GLOBALS[$val];
		} else {
			return false;
		}
	}

	static function Globals_Set($key, $val) {
		$GLOBALS[$key] = $val;
	}

	static function Globals_Unset($val) {
		if (isset($GLOBALS[$val])) {
			unset($GLOBALS[$val]);
		} else {
			return false;
		}
	}
	static function Server($val) {
		if (isset($_SERVER[$val]) && $_SERVER[$val] != '') {
			return $_SERVER[$val];
		} else {
			return false;
		}
	}

	static function Server_Set($key, $val) {
		$_SERVER[$key] = $val;
	}

	static function Server_Unset($val) {
		if (isset($_SERVER[$val])) {
			unset($_SERVER[$val]);
		} else {
			return false;
		}
	}

	static function Session($val) {
		if (isset($_SESSION[$val]) && $_SESSION[$val] != '') {
			return $_SESSION[$val];
		} else {
			return false;
		}
	}

	static function Session_Unset($val) {
		if (isset($_SESSION[$val])) {
			unset($_SESSION[$val]);
		} else {
			return false;
		}
	}

	static function Session_Set($key, $val) {
		$_SESSION[$key] = $val;
	}

	public static function Session_Start() {
		if (!isset($_SESSION))
			session_start();
	}

	public static function Session_Stop($id) {
		if ($id > 0) {
			session_unset();
			session_destroy();
			return TRUE;
		} else
			return false;
	}
	
	public static function Lock($view) {
		array_push(Config::$data['disabled'], $view);
	}
	
	public static function UnLock($view) {
		foreach (Config::$data['disabled'] as $key => $value) {
			if ($value==$view) {
				unset(Config::$data['disabled'][$key]);
			}
		}
	}
	
	public static function Enable($view) {
		array_push(Config::$data['enabled'], $view);
	}
	
	public static function Disable($view) {
		foreach (Config::$data['enabled'] as $key => $value) {
			if ($value==$view) {
				unset(Config::$data['enabled'][$key]);
			}
		}
	}
	public static function Inc($class){
		//echo APP.$class.EXT;
		if(file_exists(APP.$class.EXT)  && is_file(APP.$class.EXT)){	
			require_once(APP.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}
}
?>