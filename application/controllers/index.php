<?php
class Index extends XCoreRender {

	public function onInit(){
		// call in __constructor
		$this->Model(SYS.M.'model');
		if(isset($_GET['error']))
		$this->error = $_GET['error'];
		if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
	
		return TRUE;
	}

	public function onEnd(){
		// call after render view
		if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
		return TRUE;
	}

	public function onDestruct(){
		// call in __destructor
		return TRUE;
	}

	public function onRun(){
		// call before render view

		//$this->SetView(SYS.V.'index');
		//if($this->error == 404) $this->Exceptions(NULL,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
		
		$this->message = memory_get_usage(TRUE);
		$this->registerPHPFunctions();
		$this->ViewData('title', "XSL");
		$this->ViewData('content', $this->model->check());
		$this->ViewData('message', " i leży " );
		
		$this->setParameter('', 'test', convert(memory_get_usage(TRUE))." ".cpu_get_usage());
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