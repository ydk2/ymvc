<?php
require_once(ROOT.CORE.'systemexception'.EXT);
class XCoreRender extends XSLTProcessor {
	const ACCESS_ANY = 1000;
	const ACCESS_USER = 500;
	const ACCESS_EDITOR = 300;
	const ACCESS_MODERATOR = 100;
	const ACCESS_SYSTEM = 1;
	const ACCESS_ADMIN = 0;
	
public $model;
public $data;
public $view;
public $action;
public $modules;

public $name;
public $access;

public $emessage;
public $error;

public static $obj;
public static $obj_name;

   final public function __construct() {
		try {
		$retval = NULL;
		if (!$this->hasExsltSupport()) {
            throw new SystemException('EXSLT not supported',510);
        }
		$this->name=get_class($this);
		
		$this->data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data/>', null, false);

		if (!isset($this -> access)):
			$this -> access = self::ACCESS_ANY;
		endif;

		if (is_null($this -> error)):
			$this -> error = 0;
		endif;

        $argsv = func_get_args();
        $argsc = func_num_args();
        if (method_exists($this, $f = 'load_' . $argsc)) {
            $retval = call_user_func_array(array($this, $f), $argsv);
        }
		$this->action = new stdClass;
		$this->modules = new stdClass;
		$this->action->init = $this->onInit();
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
    
    final private function load_1($view = '') {
		try {
		if (!$this->CheckView($view)) throw new SystemException("View not exists",404);
        $this->view = $view;
		} catch (SystemException $e){
            $this->error = $e->Code();
            $this->emessage= $e->Message();
            return FALSE;
        }
    }
    
    final private function load_2($model,$view) {
        try {
		if (!$this->CheckView($view)) throw new SystemException("View not exists",404);
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
	public function onInit(){
		return TRUE;
	}

	public function onRun(){
		return TRUE;
	}

	public function onEnd(){
		return TRUE;
	}

	public function onDestruct(){
		return TRUE;
	}
	
	public final function CheckModel($model){
		if($this->Inc($model)){
			$stack = explode(DS,$model);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
			if(class_exists($end)) return TRUE;
		}
	}

final public function SetView($view) {
	if(file_exists(ROOT.$view.XSL) && is_file(ROOT.$view.XSL)) {
		$this->view = $view;
	}
}	
final public function CheckView($view) {
	if(file_exists(ROOT.$view.XSL) && is_file(ROOT.$view.XSL)) {
		return TRUE;
	}
	$this->error = 404;
	return FALSE;
}

final public function CheckController($controller) {
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
			if(class_exists($end)) return TRUE;
		} 
}
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
        
    final public function Show($view = NULL) {
        echo $this->view($view);
    }

    final public function View($path=NULL) {
        # code...
        try {
			self::$obj =& $this;
			if($path!=NULL) $this->view=$path;
			$this->action->run = $this->onRun();
			if($this->model==NULL){
				 throw new SystemException("App Model not Definied",304);
			}
			if($this->view==NULL){
				 throw new SystemException("View not Definied",401);
			}
			if (!$this->CheckView($this -> view)){
				 throw new SystemException("View not exists",404);
			}	
            if($this->error > 0) {
            if(isset($this->exception)){
                    throw new SystemException($this->emessage,$this->error);
                }
            }
			$view = new DOMDocument();
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
			if(isset($this->exception)){
            	$this->exception->ViewData('error' ,$e->Code());
            	$this->exception->ViewData('emessage' ,$e->Message());
				return $this->exception->view();
			}
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
		if (is_object($controller)) {
			$this->modules->$controller = $controller;
		} else {
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$this->modules->$end = new $end($model,$view);
			}
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
		} else {
		if($this->Inc($model)){
			$stack = explode(DS,$model);
			$end = end($stack);
			if(!class_exists($end)) return NULL;
				$this->model = new $end;
			} else {
				return NULL;
			}
		}
	}
	
    final public static function Call($method, $parameters=""){
		
		$a = self::$obj->name."::".$method;
		if(self::$obj !== NULL && method_exists(self::$obj, $method))
        return call_user_func_array(array(self::$obj, $method), explode(";", $parameters));
		//return FALSE;
    }
	
	public final function Inc($class){
		if(file_exists(ROOT.$class.EXT) && is_file(ROOT.$class.EXT)){	
			require_once(ROOT.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}
	
   public static function Trace(){
	if(defined('TRACE')){
    $e = new SystemException();
    $trace = explode("\n", $e->getTraceAsString());
    // reverse array to make steps line up chronologically
    $trace = array_reverse($trace);
    array_shift($trace); // remove {main}
    array_pop($trace); // remove call to this method
    $length = count($trace);
    $result = array();
   
    for ($i = 0; $i < $length; $i++)
    {
        $result[] = ($i + 1)  . ')' . substr($trace[$i], strpos($trace[$i], ' ')); // replace '#someNum' with '$i)', set the right ordering
    }
   
    return nl2br("\t" . implode("\n\t", $result));
	}
}  
}
?>