<?php
class Loader {
	const XSL = 0;
	const PHP = 1;

	public final function load($controller,$view){
		if (is_object($controller)) {
			return $controller;
		} else {
		$this->Inc(CORE.'corerender');
		$this->Inc(CORE.'xcorerender');
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$viewer = new $end($view);
				return	$viewer->view($view);
		} 
		}
	}
	public final function app($controller, $view){
		return $this->load(APP_C.$controller,APP_V.$view);
	}
	public final function sys($controller, $view){
		return $this->load(SYS_C.$controller,SYS_V.$view);	
	}
	final public  function Inc($class){
		if(file_exists(APP.$class.EXT)  && is_file(APP.$class.EXT)){	
			require_once(APP.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}
}
?>