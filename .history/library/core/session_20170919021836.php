<?php

class Session
{
	
	static function Get($val)
	{
		if (isset($_SESSION[$val]) && $_SESSION[$val] != '') {
			return $_SESSION[$val];
		}
		else {
			return false;
		}
	}

	static function Del($val)
	{
		if (isset($_SESSION[$val])) {
			unset($_SESSION[$val]);
		}
		else {
			return false;
		}
	}

	static function Set($key, $val)
	{
		$_SESSION[$key] = $val;
	}

	public static function Start()
	{
		if (!isset($_SESSION))
			session_start();
		session_regenerate_id(true); // regenerates SESSIONID to prevent hijacking			

	}

	public static function Stop($id)
	{
		if ($id > 0) {
			session_unset();
			session_destroy();
			return TRUE;
		}
		else
			return false;
	}

}
?>