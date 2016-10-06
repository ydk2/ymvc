<?php
class Error extends XCoreRender {

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
		//$this->ViewData('message', " i leży");
	}
	public function xxx(){
		//echo 'chuj';
		$this->data->message = " i mocniej wali";
	}

}
?>