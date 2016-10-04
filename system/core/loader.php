<?php
class Loader {
	const XSL = 0;
	const PHP = 1;

	public final function load($class){

	}
	public final function app($controller, $view){
		
	}
	public final function sys($controller, $view, $mode=1){
		if($mode === 1){
		$this->Inc(CORE.'corerender');
		$loader = new CoreRender;
		$viewer = $loader->Controller(SYS_C.$controller);
		$viewer->registerPHPFunctions();
		$viewer->show(SYS_V.$view);
		}
		if($mode === 0){
		$this->Inc(CORE.'xcorerender');
		$loader = new XCoreRender;
		$viewer = $loader->Controller(SYS_C.$controller);
		$viewer->show(SYS_V.$view);
		}	
	}
	final public  function Inc($class){
		//echo APP.$class.EXT;
		if(file_exists(APP.$class.EXT)  && is_file(APP.$class.EXT)){	
			require_once(APP.$class.EXT);
			return TRUE;
		}
		return FALSE;
	}
}
?>