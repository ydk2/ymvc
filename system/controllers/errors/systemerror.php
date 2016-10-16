<?php
class SystemError extends XSLRender {

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
		//$this->error = 40100;
		//$this->ViewData('title', "Error!!! ".$this->ViewData('error'));
		//$this->ViewData('header', "Error on site!!!");
		//$this->ViewData('alert', "System catch error: ");
		$this->ViewData('links', "" );
		$links = $this->data->links->addChild('a','Back to Index');
		$links->addAttribute('href', HOST_URL);
	}
}
?>