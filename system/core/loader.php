<?php
class Loader {
	const XSL = 0;
	const PHP = 1;
	
	final public static function get_module($controller,$view=NULL,$model = NULL){
		$me = new Loader;
		$me->Inc(CORE.'phprender');
		$me->Inc(CORE.'xslrender');
		if($me->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$module= new $end($model,$view);
				return	$module;
		} 
	}

	final public static function get_module_view($controller,$view=NULL,$model = NULL){
		$me = new Loader;
		$me->Inc(CORE.'phprender');
		$me->Inc(CORE.'xslrender');
		if($me->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$viewer = new $end($model,$view);
				return	$viewer->view();
		} 
	}
	final public static function get_module_show($controller,$view=NULL,$model = NULL){
		$me = new Loader;
		$me->Inc(CORE.'phprender');
		$me->Inc(CORE.'xslrender');
		if($me->Inc($controller)){
			$stack = explode(DS,$controller);
			$end = end($stack);
			if(!class_exists($end)) return FALSE;
				$viewer = new $end($model,$view);
				$viewer->show();
		} 
	}
	public final function returnapp($controller, $view){
		return self::get_module_view(APP.C.$controller,APP.V.$view);
	}
	public final function returnsys($controller, $view){
		return self::get_module_view(SYS.C.$controller,SYS.V.$view);	
	}
	public final function showapp($controller, $view){
		return self::get_module_show(APP.C.$controller,APP.V.$view);
	}
	public final function showsys($controller, $view){
		return self::get_module_show(SYS.C.$controller,SYS.V.$view);	
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