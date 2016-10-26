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
 * @version    2.0.0
 * @link       http://ymvc.ydk2.tk
 * @see        PHPRender
 * @since      File available since Release 1.0.0
 
 */

class XSLRender extends XSLTProcessor {
	const ACCESS_ANY = 1000;
	const ACCESS_USER = 500;
	const ACCESS_EDITOR = 300;
	const ACCESS_MODERATOR = 100;
	const ACCESS_SYSTEM = 1;
	const ACCESS_ADMIN = 0;
	

private $action;

protected $modules;
protected $only_registered_views;
protected $registered_views;

public $name;
public $access;
public $model;
public $data;
public $view;
public $emessage;
public $error;

private static $obj;

/**
*  XSLRender Class constructor can have options $model,$view or $view
* $model and $view can be definied in onInit method
* @access public
* @see __construct_1
* @see __construct_2
* @see onInit
* @param mixed $model optional can set later, can be object or path
* @param string $view optional can set later
* @return XSLRender object or boolean
**/
   final public function __construct() {
		try {
		$retval = NULL;
		if (!$this->hasExsltSupport()) {
            throw new SystemException('EXSLT not supported',20510);
        }
		$this->name=get_class($this);
		$this->only_registered_views = FALSE;
		$this->registered_views = array();
		$this->data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data/>', null, false);

		if (!isset($this -> access)):
			$this -> access = self::ACCESS_ANY;
		endif;

		if (is_null($this -> error)):
			$this -> error = 0;
		endif;

		$this->action = new stdClass;
		$this->modules = array();

        $argsv = func_get_args();
        $argsc = func_num_args();
        if (method_exists($this, $f = '__construct_' . $argsc)) {
            $retval = call_user_func_array(array($this, $f), $argsv);
        }
		$this->_check();
		$this->action->init = $this->onInit();
		$this->_check();
		if($this->error > 0) {
		if(isset($this->exception)){
			throw new SystemException($this->emessage,$this->error);
		}
		}
        } catch (SystemException $e){
            $this->error = $e->Code();
            $this->emessage= $e->Message();
            return FALSE;
        } 
    }

 /**
*  XSLRender Class sub constructor it have option $view 
* @access public
* @see onInit
* @param string $view optional can set later
* @return XSLRender object or boolean
**/   
    final private function __construct_1($view = '') {
		try {
		if (!$this->CheckView($view)) throw new SystemException("View not exists",20404);
        $this->view = $view;
		} catch (SystemException $e){
            $this->error = $e->Code();
            $this->emessage= $e->Message();
            return FALSE;
        }
    }

 /**
*  XSLRender Class sub constructor it have options $model & $view
* @access public
* @see onInit
* @param mixed $model optional can set later, can be object or path
* @param string $view optional can set later
* @return XSLRender object or boolean
**/     
    final private function __construct_2($model,$view) {
        try {
		if (!$this->CheckView($view)) throw new SystemException("View not exists",20404);
        $this->view = $view;
		if (is_object($model)) {
			$this->model = $model;
		} else {
			$this->CheckModel($model);
		}
		} catch (SystemException $e){
            $this->error = $e->Code();
            $this->emessage= $e->Message();
            return FALSE;
        }
    }

 /**
* Virtual method used in childs classes called in parent(this) class constructor 
* Used as child constructor before render views
* @access public
* @param mixed optional
* @return optional user defined
**/  
	public function onInit(){
		return TRUE;
	}

 /**
*  Virtual method used in childs classes called when view is show or return
* Used as runtime method
* @access public
* @param mixed optional
* @return optional user defined
**/ 
	public function onRun(){
		return TRUE;
	}

 /**
*  Virtual method used in childs classes called when view is returned without error
* @access public
* @param mixed optional
* @return optional user defined
**/ 
	public function onEnd(){
		return TRUE;
	}

 /**
* Virtual method used in childs classes called in parent(this) class destructor 
* Used as child destructor not required
* @access public
* @param mixed optional
* @return optional user defined
**/  
	public function onDestruct(){
		return TRUE;
	}

 /**
* Virtual method used in childs classes called on exception is throwed 
* Used as child destructor not required
* @access public
* @param mixed optional
* @return optional user defined
**/  
	public function onException(){
		return TRUE;
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
			if(!class_exists($end)) return FALSE;
			if(class_exists($end)) return TRUE;
		}
	}

 /**
* Set new View file path value if exists
* @access public
* @param string $view
**/ 
final public function SetView($view) {
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
final public function CheckController($controller) {
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
			if(class_exists($end)) return TRUE;
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


	final public function ViewData() {
			$argsv = func_get_args();
			$argsc = func_num_args();
			if (method_exists($this, $f = 'Data_' . $argsc)) {
				return call_user_func_array(array($this, $f), $argsv);
			}
		}

	final private function Data_1($value = '') {
		return (isset($this ->data->$value)) ? $this ->data->$value : '';
	}

	final private function Data_2($name, $newvalue = '') {
		if($this ->data instanceof SimpleXMLElement){
			unset($this ->data->$name);
			$this->data->addChild($name,$newvalue);
		} else {
			$this ->data->$name = $newvalue;
		}
		return (isset($this ->data->$name)) ? $this ->data->$name: '';
	}

	public function toArray(SimpleXMLElement $xml)  {
		return json_decode(json_encode( $xml),TRUE);
	}

 /**
* Class destructor
* @access public
**/ 
	public function __destruct() {
		$this->action->destruct = $this->onDestruct();
		self::$obj==NULL;
		foreach ($this as $key => $value) {
			$this -> $key = NULL;
			unset($this -> $key);
		}
		unset($this);
		clearstatcache();
	}
	
	final protected function RegisterView($view) {
		array_push($this->registered_views, $view);
	}
	
	final protected function UnRegisterView($view) {
		foreach ($this->registered_views as $key => $value) {
			if ($value==$view) {
				unset($this->registered_views[$key]);
			}
		}
	}  
	final private function _check(){
			if(!in_array($this->view,$this->registered_views) && $this->only_registered_views){
				 $this->message = "View not registered";
				 $this->error = 20402;
				 
			} else {
				if($this->error == 20402){
					$this->error = 0;
				}
			}
			if($this->model==NULL){
				 $this->message = "App Model not Definied";
				 $this->error = 20304;
			} else {
				if($this->error == 20304){
					$this->error = 0;
				}
			}
			if($this->view==NULL){
				 $this->message = "View not Definied";
				 $this->error = 20401;
			} else {
				if($this->error == 20401){
					$this->error = 0;
				}
			}
			if (!$this->CheckView($this->view)){
				 $this->message = "View not exists";
				 $this->error = 20404;
			} else {
				if($this->error == 20404){
					$this->error = 0;
				}
			}
	}

    final public function Show($view = NULL) {
        echo $this->view($view);
    }

    final public function View($path=NULL) {
        # code...
        try {
			self::$obj =& $this;
			if($path!=NULL) $this->view=$path;
			$this->_check();
			$this->action->run = $this->onRun();
			$this->_check();
            if($this->error > 0) {
            	if(isset($this->exception) || $this->error == 20404){
                    throw new SystemException($this->emessage,$this->error);
                }
            }
			$view = new DOMDocument();
			$view->substituteEntities = TRUE;
			$view->loadXML(file_get_contents(ROOT.$this->view. XSL));
			$this->setParameter('', 'self', $this->name.'::Call');
            $this->importStylesheet($view);
			$retval = $this->transformToXML($this->data); 
			$this->action->end = $this->onEnd();
			self::$obj=NULL;
            return $retval;
        } catch (SystemException $e){
            $this->error = $e->Code();
            $this->emessage= $e->Message();
			$this->action->end = $this->onException();
			if(isset($this->exception)){
            	$this->exception->ViewData('error' ,$e->Code());
            	$this->exception->ViewData('emessage' ,$e->Message());
				return $this->exception->view();
			}
			self::$obj=NULL;
            return FALSE;
        } 
    }

	final public function Exceptions($model,$view,$controller) {
		if (is_object($controller)) {
			unset($this->exception);
			$this->exception = $controller;
		} else {
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
			unset($this->exception);
			$this->exception = new $end($model,$view);
		} 
		}
	}	
	public final function Register($model, $view, $controller){
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$this->modules[$end] = new $end($model,$view);
		}
	}	
	public final function Loader($model, $view, $controller){
	
		if (is_object($controller)) {
			return $controller;
		} else {
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				return new $end($model,$view);
		} 
		}
	}	
	public final function Controller($controller){
	
		if (is_object($controller)) {
			return $controller;
		} else {
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				return new $end();
		} 
		}
	}
	public final function Viewer($view,$controller){
	
		if (is_object($controller)) {
			return $controller;
		} else {
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				return new $end($view);
		} 
		}
	}
	public final function SetModel($model){
		if (is_object($model)) {
			$this->model = $model;
			if($this->error == 20304){
				$this->error = 0;
			}
		} else {
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
	
    final public static function Call($method){
		$parameters = func_get_args(); 
		array_shift($parameters);
		$a = self::$obj->name."::".$method;
		if(self::$obj !== NULL && method_exists(self::$obj, $method))
        return call_user_func_array(array(self::$obj, $method), $parameters);
    }
	
	public final function Inc($class){
		if(file_exists(ROOT.$class.EXT) && is_file(ROOT.$class.EXT)){	
			require_once(ROOT.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}
}
?>