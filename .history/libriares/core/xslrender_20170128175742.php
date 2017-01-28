<?php
require_once(ROOT.CORE.'systemexception'.EXT);
/**
 *
 * XSLRender fast and simple to use PHP MVC framework
 *
 * MVC Framework for PHP 5.2 + with XSLT files views part of YMVC System
 * Also available as PHPRender with work on php files
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
 * @subpackage XSLRender
 * @author     ydk2 <me@ydk2.tk>
 * @copyright  1997-2016 ydk2.tk
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    2.0.1
 * @link       http://ymvc.ydk2.tk
 * @see        PHPRender
 * @since      File available since Release 1.0.0
 
 */

class XSLRender extends XSLTProcessor {
	const ACCESS_ANY = 10;
	const ACCESS_USER = 5;
	const ACCESS_EDITOR = 4;
	const ACCESS_MODERATOR = 3;
	const ACCESS_SYSTEM = 2;
	const ACCESS_ADMIN = 1;
	

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
* XSLRender Class constructor can have options $model,$view or $view
* $model and $view can be definied in Init method
* @access public
* @see __construct_1
* @see __construct_2
* @see Init
* @param mixed $model optional can set later, can be object or path
* @param string $view optional can set later
* @return XSLRender object or boolean
**/
   final public function __construct() {
		$retval = NULL;
		if (!$this->hasExsltSupport()) {
             $this->error=20510;
			 return FALSE;
        }
		$this->name=get_class($this);
		$this->access_mode = 0;
		$this->only_registered_views = FALSE;
		$this->model_required = FALSE;
		$this->registered_views = array();
		$this->exceptions = FALSE;
		$this->NewData();
		if (!isset($this -> access)):
			$this -> access = self::ACCESS_ANY;
		endif;
		$this->global_access = $this->access;
		if (is_null($this -> error)):
			$this -> error = 0;
		endif;
		$this->modules = array();
		$this->access_groups = array(NULL);
		$this->current_group = NULL;
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
		if($argsc > 1){
			$view=$argsv[1];
			$model=$argsv[0];
			if($view==""){
				$view = NULL;
			}
			$view = str_replace(S,DS,$view);
        	$this->view = $view;
			if (is_object($model)) {
				$this->model = $model;
			} else {
				$this->SetModel($model);
			}
		}
		$this->_check();
		$this->Init();
    }

/**
* Virtual method used in childs classes called in parent(this) class constructor 
* Used as child constructor before render views
* @access public
* @param mixed optional
* @return optional user defined
**/  
	public function Init(){
		$this->virtual = FALSE;
	}

/**
*  Virtual method used in childs classes called when view is show or return
* Used as runtime method
* @access public
* @param mixed optional
* @return optional user defined
**/ 
	public function Run(){
		$this->virtual = FALSE;
	}

/**
*  Virtual method used in childs classes called when view is returned without error
* @access public
* @param mixed optional
* @return optional user defined
**/ 
	public function onEnd(){
		$this->virtual = FALSE;
	}

/**
* Virtual method used in childs classes called in parent(this) class destructor 
* Used as child destructor not required
* @access public
* @param mixed optional
* @return optional user defined
**/  
	public function Destruct(){
		$this->virtual = FALSE;
	}

/**
* Virtual method used in childs classes called on exception is throwed 
* Used as child destructor not required
* @access public
* @param mixed optional
* @return optional user defined
**/  
	public function Exception(){
		$this->virtual = FALSE;
	}

/**
* Check Model class/object is definied 
* @access public
* @param mixed $model Can be object or string of path to class
* @return boolean
**/  	
public final function CheckModel($model){
		if($this->Inc($model)){
			$stack = explode(DS,$model);
			$end = end($stack);
			if(class_exists($end)) return TRUE;
			return FALSE;
		}
	}

/**
* Set Access mode buildin users role
* @access public
* @param integer $access
* @param boolean $mode Default is TRUE
**/ 
final public function AccessMode($mode=1) {
	$this->access_mode = $mode;
} 

/**
* Set Access for controller buildin users role
* @access public
* @param string $view
**/ 
final public function SetAccess($access) {
	$this->access = $access;
} 

/**
* Set Access group for controller buildin users role
* @access public
* @param string $view
**/ 
final public function SetGroup($group) {
	$this->current_group = $group;
} 

/**
* Set new View file path value if exists
* @access public
* @param string $view
**/ 
final public function SetView($view) {
	$view = str_replace(S,DS,$view);
	if(file_exists(ROOT.$view.XSL) && is_file(ROOT.$view.XSL)) {
		$this->view = $view;
		if ($this->error == 20404) {
			$this->error = 0;
		}
	}
}	

/**
* Check View is exists and set error code 20404
* @access public
* @param string $view
* @return boolean
**/ 
final public function CheckView($view) {
	$view = str_replace(S,DS,$view);
	if(file_exists(ROOT.$view.XSL) && is_file(ROOT.$view.XSL)) {
		if ($this->error == 20404) {
			$this->error = 0;
		}
		return TRUE;
	}
	$this->error = 20404;
	return FALSE;
}

/**
* Check Child controller class/object is exists
* @access public
* @param mixed $controller Can be object or string of path to class
* @return boolean
**/ 
final public function ControllerExists($controller) {
		$controller = str_replace(S,DS,$controller);
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(class_exists($end)) return TRUE;
			return FALSE;
		} 
}

/**
* Check errors
* @access public
* @return boolean
* @deprecated 0.3
**/ 
final public function CheckError() {
	if(isset($this->model->error) && $this->model->error > 0)  {
		$this->error = $this->model->error;
		return TRUE;
	}
	if(isset($this->error) && $this->error > 0)  {
		return TRUE;
	}
	return FALSE;
	}

/**
* Set New $this->data items
* @access public
* @param String $attrs Attributes list as attr=value ... or items name
* @param Mixed $items Attributes list as String attr=value ... or mixed object items
* @param Boolean $pure if TRUE return SimpleXMLElement else stdClass
**/
	public function NewData($attrs="",$items="",$pure=FALSE){
		if(!$pure){
			$this->data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data'.$attrs.'>'.$items.'</data>', null, false);
		} else {
			$this->data = new stdClass;
			$this->data->$attrs = $items;
		}
	}
/**
* Set data attributes
* @access public
* @param Array $attr Attributes list
* @return String Styled attr=value
**/
	public function DataAttr($attr){
		$attrs = '';
		if(!empty($attr)){
		foreach ($attr as $key => $value) {
			$attrs.= " $key=\"$value\"";
		}
		}
		return $attrs;
	}
/**
* Get or Set data to views
* @access public
* @param string $name Name of element
* @param mixed $value Optional new value for given name
* @return mixed Value for name
**/
	final public function ViewData() {
		$argsv = func_get_args();
		$argsc = func_num_args();

		if($argsc == 1){
			$name=$argsv[0];
			if($name==''){
				return '';
			}
			return (isset($this ->data->$name)) ? $this ->data->$name : '';
		}
		if($argsc == 2){
			$name=$argsv[0];
			$value=$argsv[1];
			if($name==''){
				return '';
			}
			if($this->data instanceof SimpleXMLElement){
				unset($this->data->$name);
				$this->data->addChild($name,$value);
			} else {
				$this->data->$name = $value;
			}
			return (isset($this->data->$name)) ? $this->data->$name: '';
		}
		return '';
	}

/**
* Get data to views
* @access private
* @see ViewData
**/ 
	final private function Data_1($name = '') {
		return (isset($this ->data->$name)) ? $this ->data->$name : '';
	}

/**
* Set data to views
* @access private
* @see ViewData
**/ 
	final private function Data_2($name, $value = '') {
		if($this ->data instanceof SimpleXMLElement){
			unset($this ->data->$name);
			$this->data->addChild($name,$value);
		} else {
			$this ->data->$name = $value;
		}
		return (isset($this ->data->$name)) ? $this ->data->$name: '';
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
		$this->Destruct();
		self::$obj==NULL;
		foreach ($this as $key => $value) {
			$this -> $key = NULL;
			unset($this -> $key);
		}
		unset($this);
		clearstatcache();
	}

/**
* Set limited View path in controller default false
* @access public
* @param boolean $state 
**/ 
	final public function only_registered($state = TRUE) {
		$this->only_registered_views = $state;
	}

/**
* Set model is required or not
* @access public
* @param boolean $state 
**/ 
	final public function model_required($state = TRUE) {
		$this->model_required = $state;
	}
	
/**
* Register View path in controller when work in limited mode
* @see only_registered
* @access public
* @param string $view
**/
	final public function RegisterView($view) {
		$view = str_replace(S,DS,$view);
		array_push($this->registered_views, $view);
	}

/**
* Unregister View path from controller when work in limited mode
* @see only_registered
* @access public
* @param string $view
**/
	final public function UnRegisterView($view) {
		$view = str_replace(S,DS,$view);
		foreach ($this->registered_views as $key => $value) {
			if ($value==$view) {
				unset($this->registered_views[$key]);
			}
		}
	}

/**
* Internal helper method to check errors or reset it.
* @access private
**/
	final private function _check(){
		if($this->error < 20400 && $this->error > 20410){
			$this->error = 0;
		}
		if($this->only_registered_views){
			if(!in_array($this->view,$this->registered_views)){
				 $this->error = 20402;
			}
		}

		if($this->access_mode == 1){
			if($this->global_access > $this->access){
				$this->error = 20403;
			}
		} elseif($this->access_mode == 2){
			if(!empty($this->access_groups) && !in_array($this->current_group,$this->access_groups)){
				$this->error = 20403;
			}
		}

		if(FALSE !== $this->model_required){
		if($this->model==NULL){
			$this->error = 20405;
		}
		}
		if($this->view==NULL){
			$this->error = 20401;
		}
		$this->CheckView($this->view);
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
* Method used to get, render and return controller view as string
* @access public
* @param string $path Optional normally set in constructor or Init
* @return string HTML output
**/ 
    final public function View($path=NULL) {
			self::$obj =& $this;
			if($path!=NULL) {
				$path = str_replace(S,DS,$path);
				$this->view=$path;
			}
			$this->_check();
            if($this->error > 0) {
				if($this->exceptions !== FALSE){
					return $this->Exception();
				}
            }
			$this->Run();
			$this->_check();
            if($this->error > 0) {
				if($this->exceptions !== FALSE){
					return $this->Exception();
				}
				return "";
            }
			$view = new DOMDocument();
			$view->substituteEntities = TRUE;
			$view->loadXML(file_get_contents(ROOT.$this->view. XSL));
			$this->setParameter('', 'self', $this->name.'::Call');
            $this->importStylesheet($view);
			$retval = $this->transformToXML($this->data);
			$this->onEnd();
			self::$obj=NULL;
            return $retval;
    }

/**
* Method used to catch exceptions and return as new controller view 
* @access public
* @param mixed $model Can be object or path or NULL, can set later in loaded controller
* @param string $view Path for view
* @param mixed $controller Can be XSLRender or PHPRender object or path
**/ 
	final public function Exceptions($model,$view,$controller) {
		if (is_object($controller)) {
			unset($this->exception);
			if(($controller instanceof XSLRender) || ($controller instanceof PHPRender)){
				if($model!==NULL)
					$controller->SetModel($model);
				if($view!==NULL)
					$controller->SetView($view);
			}
			$this->exception = $controller;
		} else {
			$controller = str_replace(S,DS,$controller);
			$view = str_replace(S,DS,$view);
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
			unset($this->exception);
			$this->exception = new $end($model,$view);
		} 
		}
	}

/**
* Method used to set new subcontroller in $this->modules Array of XSLRender or PHPRender objects
* $controller string value is stored as name in modules array
* @access public
* @param string $view Path for view
* @param string $controller 
**/ 	
	public final function SetModule($view, $controller){
		$controller = str_replace(S,DS,$controller);
		$view = str_replace(S,DS,$view);
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$this->modules[$controller] = new $end($this->model,$view);
		}
	}
	
/**
* Method used to get subcontroller by controller path from $this->modules 
* @access public
* @param string $controller 
* @return XSLRender or PHPRender object
**/ 	
public final function GetModule($controller){
	$controller = str_replace(S,DS,$controller);
	if(isset($this->modules[$controller])){
		return $this->modules[$controller];
	}
	return FALSE;
}	
	
/**
* Method used to unset subcontroller by controller path from $this->modules
* @access public
* @param string $controller 
* @return boolean
**/ 	
	public final function UnsetModule($controller){
		$controller = str_replace(S,DS,$controller);
		if(isset($this->modules[$controller])){
			unset($this->modules[$controller]);
			return TRUE;
		}
		return FALSE;
	}

/**
* Method return a new controller view 
* @access public
* @param mixed $controller Can be XSLRender or PHPRender object or path
* @return XSLRender or PHPRender object
**/ 
	public final function NewControllerA($controller){
	
		if (is_object($controller)) {
			return $controller;
		} else {
		$controller = str_replace(S,DS,$controller);
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				return new $end();
		} 
		}
	}

/**
* Method return a new controller view 
* @access public
* @param string $view Path for view
* @param mixed $controller Can be XSLRender or PHPRender object or path
* @return XSLRender or PHPRender object
**/ 
	public final function NewControllerB($view,$controller){
	
		if (is_object($controller)) {
			if(($controller instanceof XSLRender) || ($controller instanceof PHPRender)){
				if($view!==NULL)
					$controller->SetView($view);
			}
			return $controller;
		} else {
			$controller = str_replace(S,DS,$controller);
			$view = str_replace(S,DS,$view);
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				return new $end($view);
		} 
		}
	}

/**
* Method return a new controller view with model
* @access public
* @param mixed $model Can be object or path or NULL, can set later in loaded controller
* @param string $view Path for view
* @param mixed $controller Can be XSLRender or PHPRender object or path
* @return XSLRender or PHPRender object
**/ 
	public final function NewController($model, $view, $controller){
	
		if (is_object($controller)) {
			if(($controller instanceof XSLRender) || ($controller instanceof PHPRender)){
				if($model!==NULL)
					$controller->SetModel($model);
				if($view!==NULL)
					$controller->SetView($view);
			}
			return $controller;
		} else {
			$controller = str_replace(S,DS,$controller);
			$view = str_replace(S,DS,$view);
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				return new $end($model,$view);
		} 
		}
	}


/**
* Method set a new Model 
* @access public
* @param mixed $model Can be object or path.
* @return object Model
**/ 
	public final function SetModel($model){
		if (is_object($model)) {
			$this->model = $model;
			if($this->error == 20304){
				$this->error = 0;
			}
		} else {
		$model = str_replace(S,DS,$model);
		if($this->Inc($model)){
			$stack = explode(DS,$model);
			$end = end($stack);
			if(!class_exists($end)) return NULL;
				$this->model = new $end;
				if($this->error == 20304){
				$this->error = 0;
				}
			} else {
				return NULL;
			}
		}
	}

/**
* Method Call existing method in this class or child from XSLTProcessor
* @access public
* @param string $method Call existing method in this class from XSLTProcessor
* @param mixed $arguments Multiple arguments ... 
* @return mixed Result from called method
**/ 	
    final public static function Call($method){
		$parameters = func_get_args(); 
		array_shift($parameters);
		$a = self::$obj->name."::".$method;
		if(self::$obj !== NULL && method_exists(self::$obj, $method))
        return call_user_func_array(array(self::$obj, $method), $parameters);
    }

/**
* Method check and preload class file 
* @access public
* @param string $class
**/ 	
	public final function Inc($class){
		if(file_exists(ROOT.$class.EXT) && is_file(ROOT.$class.EXT)){	
			require_once(ROOT.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}
/**
* Insert XML into a SimpleXMLElement
* @from http://stackoverflow.com/questions/767327/in-simplexml-how-can-i-add-an-existing-simplexmlelement-as-a-child-element
* @param SimpleXMLElement $parent
* @param string $xml
* @param bool $before
* @return bool XML string added
*/
function simplexml_import_xml(SimpleXMLElement $parent, $xml, $before = false) {
	$xml = (string)$xml;
	// 	check if there is something to add
	if ($nodata = !strlen($xml) or $parent[0] == NULL) {
		return $nodata;
	}
	// 	add the XML
	$node = dom_import_simplexml($parent);
	$fragment = $node->ownerDocument->createDocumentFragment();
	$fragment->appendXML($xml);
	if ($before) {
		return (bool)$node->parentNode->insertBefore($fragment, $node);
	}
	return (bool)$node->appendChild($fragment);
}
/**
* Insert SimpleXMLElement into SimpleXMLElement
* @from http://stackoverflow.com/questions/767327/in-simplexml-how-can-i-add-an-existing-simplexmlelement-as-a-child-element
* @param SimpleXMLElement $parent
* @param SimpleXMLElement $child
* @param bool $before
* @return bool SimpleXMLElement added
*/
function simplexml_import_simplexml(SimpleXMLElement $parent, SimpleXMLElement $child, $before = false){
	// 	check if there is something to add
	if ($child[0] == NULL) {
		return true;
	}
	// 	if it is a list of SimpleXMLElements default to the first one
	$child = $child[0];
	// 	insert attribute
	if ($child->xpath('.') != array($child)) {
		$parent[$child->getName()] = (string)$child;
		return true;
	}
	$xml = $child->asXML();
	// 	remove the XML declaration on document elements
	if ($child->xpath('/*') == array($child)) {
		$pos = strpos($xml, "\n");
		$xml = substr($xml, $pos + 1);
	}
	return simplexml_import_xml($parent, $xml, $before);
}

/**
* Sort array by key
* @param Array $array
* @param String $subkey
* @param bool $sort_ascending
*/
function sksort(&$array, $subkey="", $sort_ascending=TRUE) {
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
}
?>