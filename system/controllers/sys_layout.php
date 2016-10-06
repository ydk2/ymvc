<?php
class Sys_Layout extends XCoreRender {
	private $time;
	public function onInit(){
		// call in __constructor
		$this->time[0]=get_time();
		$this->Model(SYS_M.'model');
		$this->registerPHPFunctions();
		if(isset($_GET['error']))
		$this->error = $_GET['error'];
		if($this->error > 0) $this->Exceptions($this->model,SYS_V.'errors'.DS.'error',SYS_C.'errors'.DS.'error');
		return TRUE;
	}

	public function onEnd(){
		// call after render view
		if($this->error > 0) $this->Exceptions($this->model,SYS_V.'errors'.DS.'error',SYS_C.'errors'.DS.'error');
		return TRUE;
	}

	public function onDestruct(){
		// call in __destructor
		$model = new StdClass;
		$this->time[1]=get_time();
		$model->time = get_time_exec($this->time[0],$this->time[1]);

		$time = $this->Loader($model,SYS_V.'time',SYS_C.'view');
		$time->Show();
		return TRUE;
	}

	public function onRun($model = NULL){


		//$this->SetView(SYS_V.'index');
		//if($this->error == 404) $this->Exceptions(NULL,SYS_V.'errors'.DS.'error',SYS_C.'errors'.DS.'error');
		
		$this->message = memory_get_usage(TRUE);
		$this->ViewData('title', "XSL");
		$this->ViewData('content', $this->model->check());
		$this->ViewData('message', " i leży " );
		$a = round(2.70, 2);
		$b = round(cpu_get_usage(), 2); //0.17
		if($a <= $b ){
    		$this->error = 2100;
			$this->message = "To many CPU used";
		}
		$this->setParameter('', 'test', convert(memory_get_usage(TRUE))." ".abs(cpu_get_usage()));
		//if($this->error > 0) $this->Exceptions($this->model,SYS_V.'errors'.DS.'error',SYS_C.'errors'.DS.'error');
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