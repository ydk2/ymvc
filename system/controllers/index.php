<?php
class Index extends CoreRender {

	public function onInit(){
		// call in __constructor
		$this->registerPHPFunctions();
		return TRUE;
	}

	public function onEnd(){
		// call after render view
		return TRUE;
	}

	public function onDestruct(){
		// call in __destructor
		return TRUE;
	}

	public function onRun($model = NULL){
		$this->ViewData('title', "PHP View");
		$this->ViewData('header', "Controller with PHP View");
		$this->ViewData('alert', "Content for  this module");
	}

}
?>