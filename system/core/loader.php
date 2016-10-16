<?php
class Loader {
	const XSL = 0;
	const PHP = 1;
	
	public final function load($view,$controller){
		$this->Inc(CORE.'phprender');
		$this->Inc(CORE.'xslrender');
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
	public final function view($controller,$view){
		if (is_object($controller)) {
			return $controller;
		} else {
		$this->Inc(CORE.'phprender');
		$this->Inc(CORE.'xslrender');
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$viewer = new $end($view);
				return	$viewer->view($view);
		} 
		}
	}
	public final function show($controller,$view){
		if (is_object($controller)) {
			return $controller;
		} else {
		$this->Inc(CORE.'phprender');
		$this->Inc(CORE.'xslrender');
		if($this->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$viewer = new $end($view);
				$viewer->Show($view);
		} 
		}
	}
	public final function returnapp($controller, $view){
		return $this->load(APP.C.$controller,APP.V.$view);
	}
	public final function returnsys($controller, $view){
		return $this->load(SYS.C.$controller,SYS.V.$view);	
	}
	public final function showapp($controller, $view){
		$this->show(APP.C.$controller,APP.V.$view);
	}
	public final function showsys($controller, $view){
		$this->show(SYS.C.$controller,SYS.V.$view);	
	}
	final public  function Inc($class){
		if(file_exists(ROOT.$class.EXT)  && is_file(ROOT.$class.EXT)){	
			require_once(ROOT.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}
}
?>