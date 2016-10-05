<?php
class Index extends XCoreRender {

	public function onInit(){
		// call in __constructor
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
		// call before render view
		$this->Model(SYS_M.'model');

		//$this->SetView(SYS_V.'index');
		//if($this->error == 404) $this->Exceptions(NULL,SYS_V.'errors'.DS.'error',SYS_C.'errors'.DS.'error');
		if(isset($_GET['error']))
		$this->error = $_GET['error'];
		$this->message = memory_get_usage(TRUE);
		$this->registerPHPFunctions();
		$this->ViewData('title', "XSL");
		$this->ViewData('content', $this->model->check());
		$this->ViewData('message', " i leży " );
		
		$this->setParameter('', 'test', convert(memory_get_usage(TRUE))." ".cpu_get_usage());
		if($this->error > 0) $this->Exceptions($this->model,SYS_V.'errors'.DS.'error',SYS_C.'errors'.DS.'error');
	}
	protected function test(){
		$retarr = "";
		foreach(PDO::getAvailableDrivers() as $driver)
       {
       $retarr .= '<p>'.$driver.'</p>';
       }
		$this->ViewData('message', " i leży tam" );
	   return $retarr;
	}
	
}
?>