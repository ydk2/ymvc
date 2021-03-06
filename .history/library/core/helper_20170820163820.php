<?php
/**
* 
 * PHPRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
 * Helper Class to easy get set post session etc...
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Framework, MVC
 * @package    YMVC System
 * @subpackage Helper
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    4.12.0
 * @link       http://ymvc.ydk2.tk
 * @see        YMVC System
 * @since      File available since Release 1.0.0
 
 */
namespace Library\Core;

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

	static function Cookie_Get($val) {
		if (isset($_COOKIE[$val]) && $_COOKIE[$val] != '') {
			return $_COOKIE[$val];
		} else {
			return false;
		}
	}

	static function Cookie_Set($key, $val) {
		if (isset($_COOKIE[$key])) {
			setcookie($key,$val);
		} else {
			return false;
		}
	}

	static function Cookie_Register($key, $val, $int) {
		if (isset($_COOKIE[$key])) {
			setcookie($key,$val);
		} else {
			setcookie($key,$val,time()+$int);
		}
	}

	static function Cookie_UnSet($key) {
		if (isset($_COOKIE[$key])) {
			unset($_COOKIE[$key]);
			//setcookie($key,"",time()-1);
		} else {
			return false;
		}
	}

	static function Globals_Get($val) {
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
	static function Server_Get($val) {
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

	static function Session_Get($val) {
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
			session_regenerate_id(true); // regenerates SESSIONID to prevent hijacking			
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

	public static function Inc($class)
    {
        $filename = strtolower(str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ROOT . DIRECTORY_SEPARATOR . $class));
        if (file_exists($filename) && is_file($filename)) {
            require_once ($filename);
            return TRUE;
        }
        return FALSE;
	}

	public static function IncExt($class){
		//echo APP.$class.EXT;
		if(file_exists($class)  && is_file($class)){
			require_once($class);
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
	public static function sortby(&$array, $subkey="", $sort_ascending=TRUE) {
	if (count($array))
	$temp_array[key($array)] = array_shift($array);
	foreach($array as $key => $val){
		$offset = 0;
		$found = false;
		foreach($temp_array as $tmp_key => $tmp_val) {
			if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])) {
				$temp_array = array_merge((array)array_slice($temp_array,0,$offset), array($key => $val), array_slice($temp_array,$offset));
				$found = true;
			}
			$offset++;
		}
		if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
	}
	if ($sort_ascending) $array = array_reverse($temp_array);
	else $array = $temp_array;
	}

/**
* Load and call class
* @param String $classpath
* @return Class Object
*/
    final public static function Loader($class){
        if (is_object($class)) {
            return $class;
        }
        else {
            $ext = '.php';
            $path= strtolower(str_replace(array('\\', '/'), '\\',  $class));
            if (self::Inc($path,$ext)) {
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
public static function array_url($queries){
    $query = explode("&", $queries);
	$new = array();
    foreach($query as $value)
    {
		$a=explode("=", $value);
		if(isset($a[1])){
    		list($k,$v) = $a;
			$new[$k]=$v;
		} else {
			$new[$value]=NULL;
		}
    }
    return $new;
}

/**
* Convert array to URI query string
* @param Array $array
* @return String query URI
*/
public static function query_url($array){
	$query = array();
	foreach ($array as $key => $value) {
		if(isset($value)){
			$query[]=$key.'='.$value;
		} else {
			$query[]=$key;
		}
	}
    return implode('&',$query);
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
public static function validate($entry,$type='text',$min=3,$max=30,$glue='-'){
    switch ($type) {
        case 'pass':
        case 'alphanum':
        if (!ctype_alnum($entry) || (strlen($entry)<$min || strlen($entry)>$max)) {
            return FALSE;
        } break;
        case 'uri':
        if (!filter_var($entry, FILTER_VALIDATE_URL)) {
            return FALSE;
        } break;
        case 'email':
        if (!filter_var($entry, FILTER_VALIDATE_EMAIL)) {
            return FALSE;
        } break;
        case 'date':
        $test = explode($glue, $entry);
		$range = date_diff(date_create($entry),date_create(date('d-m-Y')));
		$xage = ($range->y>=$min || $min==0)?true:false;
		$yage = ($range->y<=$max || $max==0)?true:false;
        if (count($test)!=3 || !checkdate($test[1], $test[0], $test[2]) || !$xage || !$yage) {
            return FALSE;
        } break;
        case 'num':
        if (!is_numeric($entry) || (strlen($entry)<$min || strlen($entry)>$max)) {
            return FALSE;
        } break;
        case 'html':
        $doc = new DOMDocument();
        $doc->loadHTML($entry);
        if (!$doc->validate() || (strlen($entry)<$min || strlen($entry)>$max)) {
            return FALSE;
        } break;
        case 'xml':
        $doc = new DOMDocument();
        $doc->loadXML($entry);
        if (!$doc->validate() || (strlen($entry)<$min || strlen($entry)>$max)) {
            return FALSE;
        } break;
        case 'text':
        default:
        if (!isset($entry) || (strlen($entry)<$min || strlen($entry)>$max)) {
            return FALSE;
        } break;
    }
	return TRUE;
}
public static function Dump($string){
	ob_start();
	var_dump($string);
	$out = ob_get_clean();
	return $out;
}
public static function get_uri(){
	$url=(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')?'https://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/':'http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/';
	return $uri;
}
}
?>