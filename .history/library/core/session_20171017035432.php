<?php
/**
 * Created on Tue Sep 19 2017
 *
 * The MIT License (MIT)
 * Copyright (c) 2017 ydk2
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so,
 * subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial
 * portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED
 * TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT,
 * TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 **/

namespace Library\Core;
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
		//if(!session_id()) session_regenerate_id(true); // regenerates SESSIONID to prevent hijacking			

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