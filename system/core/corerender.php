<?php
require_once(ROOT.CORE.'systemexception'.EXT);
class CoreRender {
	const ACCESS_ANY = 1000;
	const ACCESS_USER = 500;
	const ACCESS_EDITOR = 300;
	const ACCESS_MODERATOR = 100;
	const ACCESS_SYSTEM = 1;
	const ACCESS_ADMIN = 0;

private $registerPHPFunctions;
private $parameters;
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

   final public function __construct() {
		try {
		$retval = NULL;
		$this->registerPHPFunctions = TRUE;
		$this->name=get_class($this);
		$this->only_registered_views = FALSE;
		$this->registered_views = array();
		
		$this->data = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><data/>', null, false);
		
		$this->parameters = array();
		
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
        if (method_exists($this, $f = 'load_' . $argsc)) {
            $retval = call_user_func_array(array($this, $f), $argsv);
        }
		$this->_check();
		$this->action->init = $this->onInit();
		$this->_check();
		if($this->error > 0) {
		if(isset($this->exception)){
			//$this->view = VIEWS.'empty';
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
		if (!$this->CheckView($view)) throw new SystemException("View not exists",20404);
        $this->view = $view;
		} catch (SystemException $e){
            $this->error = $e->Code();
            $this->emessage= $e->Message();
            return FALSE;
        }
    }
    
    final private function load_2($model,$view) {
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
	if(file_exists(ROOT.$view.EXT)  && is_file(ROOT.$view.EXT)) {
		$this->view = $view;
	}
}

final public function CheckView($view) {
	if(file_exists(ROOT.$view.EXT)  && is_file(ROOT.$view.EXT)) {
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
			}
			if($this->model==NULL){
				 $this->message = "App Model not Definied";
				 $this->error = 20304;
			}
			if($this->view==NULL){
				 $this->message = "View not Definied";
				 $this->error = 20401;
			}
			if (!$this->CheckView($this->view)){
				 $this->message = "View not exists";
				 $this->error = 20403;
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
            if(isset($this->exception)){
                    throw new SystemException($this->emessage,$this->error);
                }
            }
			if($this->registerPHPFunctions){
			ob_start();
			echo "";
			if ($this->CheckView($this -> view))
			require_once(ROOT.$this->view.EXT);
			$retval = ob_get_clean();
			} else {
				$retval = "";
				if ($this->CheckView($this -> view))
				$retval = file_get_contents(ROOT.$this->view.EXT);
			}
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
	//	$this->exception->Init();
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

    final public static function Call($method, $parameters=""){
		
		$a = self::$obj->name."::".$method;
		if(self::$obj !== NULL && method_exists(self::$obj, $method))
        return call_user_func_array(array(self::$obj, $method), explode(";", $parameters));
		//return FALSE;
    }
	
	public final function Inc($class){
		//echo ROOT.$class.EXT;
		if(file_exists(ROOT.$class.EXT) && is_file(ROOT.$class.EXT)){	
			require_once(ROOT.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}
	
   final public function setParameter($namespace,$key,$value){
		if($namespace != ''){
			$this->parameters[$namespace][$key] = $value;
		} else {
			$this->parameters['/'][$key] = $value;
		}
	}	
   final public function getParameter($namespace,$key){
		if($namespace != ''){
			return $this->parameters[$namespace][$key];
		} else {
			return $this->parameters['/'][$key];
		}
	}
		
   final public function registerPHPFunctions(){
		$this->registerPHPFunctions = TRUE;
	}
 
}
?>