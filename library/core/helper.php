<?php
/**
 * Created on Thu Mar 01 2018
 *
 * YMVC framework License
 * Copyright (c) 1996 - 2018 ydk2 All rights reserved.
 * 
 * YMVC version 3 fast and simple to use 
 * PHP MVC framework for PHP 5.4 + with PHP and XSLT files 
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * Redistribution and use of this software in source and binary forms, with or without modification,
 * are permitted provided that the following condition is met:
 * Redistributions of source code must retain the above copyright notice, 
 * this list of conditions and the following disclaimer.
 *   
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, 
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED.
 * IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, 
 * OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; 
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION)
 * HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, 
 * OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 * 
 * For more information on the YMVC project, 
 * please see <http://ydk2.tk>. 
 *   
 **/

/**
 * @category   Framework, MVC
 * @package    YMVC System
 * @subpackage Helper
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    YMVC Framework License
 * @version    4.13.0
 * @link       https://ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 3.0.0
 *
 */
namespace Library\Core;

class Helper
{

	/**
	 * Get
	 * @param mixed $val 
	 * @return mixed 
	 */
	static function Get($val)
	{
		if (isset($_GET[$val]) && $_GET[$val] != '') {
			return $_GET[$val];
		}
		else {
			return false;
		}
	}

	/**
	 * Post
	 * @param mixed $val 
	 * @return mixed 
	 */
	static function Post($val)
	{
		if (isset($_POST[$val]) && $_POST[$val] != '') {
			return $_POST[$val];
		}
		else {
			return false;
		}
	}

	/**
	 * Request
	 * @param mixed $val 
	 * @return mixed 
	 */
	static function Request($val)
	{
		if (isset($_REQUEST[$val]) && $_REQUEST[$val] != '') {
			return $_REQUEST[$val];
		}
		else {
			return false;
		}
	}

	/**
	 * GlobalsGet
	 * @param mixed $val 
	 * @return mixed 
	 */
	static function GlobalsGet($val)
	{
		if (isset($GLOBALS[$val]) && $GLOBALS[$val] != '') {
			return $GLOBALS[$val];
		}
		else {
			return false;
		}
	}

	static function GlobalsSet($key, $val)
	{
		$GLOBALS[$key] = $val;
	}

	/**
	 * GlobalsDel
	 * @param mixed $val 
	 * @return mixed 
	 */
	static function GlobalsDel($val)
	{
		if (isset($GLOBALS[$val])) {
			unset($GLOBALS[$val]);
		}
		else {
			return false;
		}
	}
	/**
	 * ServerGet
	 * @param mixed $val 
	 * @return mixed 
	 */
	static function ServerGet($val)
	{
		if (isset($_SERVER[$val]) && $_SERVER[$val] != '') {
			return $_SERVER[$val];
		}
		else {
			return false;
		}
	}

	/**
	 * ServerSet
	 * @param mixed $key 
	 * @param mixed $val 
	 * @return mixed 
	 */
	static function ServerSet($key, $val)
	{
		$_SERVER[$key] = $val;
	}

	/**
	 * ServerDel
	 * @param mixed $val 
	 * @return mixed 
	 */
	static function ServerDel($val)
	{
		if (isset($_SERVER[$val])) {
			unset($_SERVER[$val]);
		}
		else {
			return false;
		}
	}
	
	/**
	 * Inc
	 * @param mixed $class 
	 * @return mixed 
	 */
	public static function Inc($class)
	{
		$filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $class));
		if (file_exists($filename) && is_file($filename)) {
			require_once ($filename);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * IncExt
	 * @param mixed $class 
	 * @return mixed 
	 */
	public static function IncExt($class)
	{
		if (file_exists($class) && is_file($class)) {
			require_once ($class);
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * Sort array by key
	 * @param Array $array
	 * @param String $subkey
	 * @param bool $sort_ascending
	 */
	public static function sortby(&$array, $subkey = "", $sort_ascending = TRUE)
	{
		if (count($array))
			$temp_array[key($array)] = array_shift($array);
		foreach ($array as $key => $val) {
			$offset = 0;
			$found = false;
			foreach ($temp_array as $tmp_key => $tmp_val) {
				if (!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
					$temp_array = array_merge((array)array_slice($temp_array, 0, $offset), array($key => $val), array_slice($temp_array, $offset));
					$found = true;
				}
				$offset++;
			}
			if (!$found) $temp_array = array_merge($temp_array, array($key => $val));
		}
		if ($sort_ascending) $array = array_reverse($temp_array);
		else $array = $temp_array;
	}

	/**
	 * Load and call class
	 * @param String $classpath
	 * @return Class Object
	 */
	final public static function Loader($class)
	{
		if (is_object($class)) {
			return $class;
		}
		else {
			$ext = '.php';
			$path = strtolower(str_replace(array('\\', '/'), '\\', $class));
			if (self::Inc($path . $ext)) {
				if (!class_exists($class)) return NULL;
				$a = func_get_args();
				array_shift($a);
				$new = new \ReflectionClass($class);
				$object = $new->newInstanceArgs($a);
				return $object;
			}
		}
	} // end Loader();


	/**
	 * Convert URI query string to array
	 * @param String $queries
	 * @return Array array pieces
	 */
	public static function array_url($queries)
	{
		$query = explode("&", $queries);
		$new = array();
		foreach ($query as $value)
			{
			$a = explode("=", $value);
			if (isset($a[1])) {
				list($k, $v) = $a;
				$new[$k] = $v;
			}
			else {
				$new[$value] = NULL;
			}
		}
		return $new;
	}

	/**
	 * Convert array to URI query string
	 * @param Array $array
	 * @return String query URI
	 */
	public static function query_url($array)
	{
		$query = array();
		foreach ($array as $key => $value) {
			if (isset($value)) {
				$query[] = $key . '=' . $value;
			}
			else {
				$query[] = $key;
			}
		}
		return implode('&', $query);
	}

	/**
	 * Validate input string by type
	 * @param String $entry
	 * @param String $type can be text, alphanum, num, uri, email, date(format d-m-Y), xml, html
	 * @param Integer $min minimum lenght of string
	 * @param Integer $max maximum lenght of string
	 * @param String $glue for date string (-)
	 * @return Boolean
	 */
	public static function validate($entry, $type = 'text', $min = 3, $max = 30, $glue = '-')
	{
		switch ($type) {
			case 'pass' :
			case 'alphanum' :
				if (!ctype_alnum($entry) || (strlen($entry) < $min || strlen($entry) > $max)) {
					return FALSE;
				}
				break;
			case 'uri' :
				if (!filter_var($entry, FILTER_VALIDATE_URL)) {
					return FALSE;
				}
				break;
			case 'email' :
				if (!filter_var($entry, FILTER_VALIDATE_EMAIL)) {
					return FALSE;
				}
				break;
			case 'date' :
				$test = explode($glue, $entry);
				$range = date_diff(date_create($entry), date_create(date('d-m-Y')));
				$xage = ($range->y >= $min || $min == 0) ? true : false;
				$yage = ($range->y <= $max || $max == 0) ? true : false;
				if (count($test) != 3 || !checkdate($test[1], $test[0], $test[2]) || !$xage || !$yage) {
					return FALSE;
				}
				break;
			case 'num' :
				if (!is_numeric($entry) || (strlen($entry) < $min || strlen($entry) > $max)) {
					return FALSE;
				}
				break;
			case 'html' :
				$doc = new DOMDocument();
				$doc->loadHTML($entry);
				if (!$doc->validate() || (strlen($entry) < $min || strlen($entry) > $max)) {
					return FALSE;
				}
				break;
			case 'xml' :
				$doc = new DOMDocument();
				$doc->loadXML($entry);
				if (!$doc->validate() || (strlen($entry) < $min || strlen($entry) > $max)) {
					return FALSE;
				}
				break;
			case 'text' :
			default :
				if (!isset($entry) || (strlen($entry) < $min || strlen($entry) > $max)) {
					return FALSE;
				}
				break;
		}
		return TRUE;
	}
	public static function Dump($string)
	{
		ob_start();
		var_dump($string);
		$out = ob_get_clean();
		return $out;
	}
	public static function get_uri()
	{
		$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) . '/' : 'http://' . dirname($_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME']) . '/';
		return $uri;
	}
}


?>