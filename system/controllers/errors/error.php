<?php
class Error extends XCoreRender {

	public function Init($model = NULL){
		//$this->error = 40100;
		$this->registerPHPFunctions();
		$this->ViewData('title', "kupa błędów");
		$this->ViewData('content', "kupa tak ogromna i śmierdzi");
		$this->ViewData('message', " i leży");
		$this->message = dump($this);
		//if($this->error == 40100) $this->Exceptions($this->model,SYS_V.'error',SYS_C.'error');
		$this->setParameter('', 'test', convert(memory_get_usage(TRUE))." ".cpu_get_usage());
		$this->setParameter('', 'dump', $this->message);
	}
	public function xxx(){
		//echo 'chuj';
		$this->data->message = " i mocniej wali";
	}

}
?>