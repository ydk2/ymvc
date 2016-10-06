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
		$this->ViewData('title', "kupa błędów");
		$this->ViewData('content', "kupa tak ogromna i śmierdzi");
		$this->ViewData('message', " i leży");
		$this->message = dump($this);
		$this->setParameter('', 'test', convert(memory_get_usage(TRUE))." ".cpu_get_usage());
		$this->setParameter('', 'dump', $this->message);
	}
	public function xxx(){
		//echo 'chuj';
		$this->data->message = " i mocniej wali";
	}

}
?>