<?php
//require_once(ROOT.CORE.'systemexception'.EXT);
namespace libriares\core;
/**
* PHPRender fast and simple to use PHP MVC framework
*
* MVC Framework for PHP 5.2 + with PHP files views part of YMVC System
* Also available as XSLRender with work on xslt files
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
* @subpackage Render
* @author     ydk2 <me@ydk2.tk>
* @copyright  1997-2016 ydk2.tk
* @license    http://www.php.net/license/3_01.txt  PHP License 3.01
* @version    1.0.0
* @link       http://ymvc.ydk2.tk
* @see        XSLRender
* @since      File available since Release 1.0.0

*/

class Render {
	const ACCESS_ANY = 10;
	const ACCESS_USER = 5;
	const ACCESS_EDITOR = 4;
	const ACCESS_MODERATOR = 3;
	const ACCESS_SYSTEM = 2;
	const ACCESS_ADMIN = 1;
	
	private $registerPHPFunctions;
	private $parameters;
	private $action;
	private $virtual;

	protected $modules;
	protected $only_registered_views;
	protected $registered_views;
	protected $global_access;
	protected $access_mode;
	protected $model_required;
	protected $exceptions;
	
	public $name;
	public $access;
	public $current_group;
	public $access_groups;
	public $model;
	public $data;
	public $view;
	public $emessage;
	public $error;
	
	private static $obj;
	
	
	/**
	* PHPRender Class constructor can have options $model,$view or $view
	* $model and $view can be definied in Init method
	* @access public
	* @see __construct_1
	* @see __construct_2
	* @see Init
	* @param mixed $model optional can set later, can be object or path
	* @param string $view optional can set later
	* @return PHPRender object or boolean
	**/
	final public function __construct() {

	
		$retval = NULL;
		$this->registerPHPFunctions = TRUE;
		$this->name=get_class($this);

		$this->parameters = array();
		if (!isset($this -> access)):
			$this -> access = self::ACCESS_ANY;
		endif;
		$this->global_access = $this->access;
		if (is_null($this -> error)):
			$this -> error = 0;
		endif;
		$this->modules = array();
        $argsv = func_get_args();
        $argsc = func_num_args();
		if($argsc == 1){
			$view=$argsv[0];
			if($view==""){
				$view = NULL;
			}
			$view = str_replace(S,DS,$view);
        	$this->view = $view;
		}
		//$this->_check();
		//$this->Init();
    }

/**
* Convert SimpleXMLElement to array
* @access public
* @param SimpleXMLElement $xml
* @return Array
**/ 
	public function toArray(SimpleXMLElement $xml)  {
		return json_decode(json_encode( $xml),TRUE);
	}
/**
* Class destructor
* @access public
**/ 
	public function __destruct() {
		self::$obj==NULL;
		foreach ($this as $key => $value) {
			$this -> $key = NULL;
			unset($this -> $key);
		}
		clearstatcache();
	}

/**
* Method used to get, render and show controller view 
* @access public
* @param string $path Optional normally set in constructor or Init
* @return Print View
**/  
    final public function Show($path = NULL) {
        echo $this->View($path);
    }
/**
* Method used to get, render and return controller sub view as string
* @access public
* @param string $path Optional normally set in constructor or Init
* @return string HTML output
**/
    final public function subView($view=NULL) {
		if($view!=NULL) {
		$view = str_replace(S,DS,$view);
		ob_start();
			echo "";
			if(file_exists(ROOT.$view.VXT) && is_file(ROOT.$view.VXT))
			require_once(ROOT.$view.VXT);
			$retval = ob_get_clean();
            return $retval;
		} else {
			return "";
		}
    }
/**
* Method used to get, render and return controller view as string
* @access public
* @param string $path Optional normally set in constructor or Init
* @return string HTML output
**/
    final public function View($path=NULL) {
    }
/**
* Sort array by key
* @param Array $array
* @param String $subkey
* @param bool $sort_ascending
*/
	function sortby(&$array, $subkey="", $sort_ascending=TRUE) {
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
* Load and call class value from brakets in html
* @param String $body content
* @return String with automated content
*/
	public function autobrakets($body){
		$m = '/\{\{(.[a-z]+?)\}\}/is';
		$in = array();
		$out = array();
		preg_match_all($m,$body,$matches,PREG_PATTERN_ORDER);
		if(isset($matches[1])){
			foreach($matches[1] as $found){
				$in[] = "{{".$found."}}";
				$out[] = $this->ViewData($found);
			}
			return str_ireplace($in,$out,$body);
		}
		return $body;
	}
}

?>