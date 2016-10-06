<?php
class Sys_Layout extends XCoreRender {
	private $time;
	public function onInit(){
		// call in __constructor
		$this->time[0]=get_time();
		$this->SetModel(SYS.M.'model');
		$this->registerPHPFunctions();
		if(isset($_GET['error']))
		$this->error = $_GET['error'];
		if($this->error > 0) {

			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');

			$this->exception->ViewData('title', "Error!!! ".$this->error);
			$this->exception->ViewData('header', "Error on Site!!!");
			$this->exception->ViewData('alert',"System catch error: ");
			$this->exception->ViewData('error', $this->error);
		}
		return TRUE;
	}

	public function onEnd(){
		// call after render view
		//if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
		return TRUE;
	}

	public function onDestruct(){
		// call in __destructor
		$model = new StdClass;
		$this->time[1]=get_time();
		$model->cpu = abs(cpu_get_usage());
		$model->mem = convert(memory_get_usage(TRUE));
		$model->time = get_time_exec($this->time[0],$this->time[1]);

		$time = $this->Loader($model,SYS.V.'time',SYS.C.'view');
		$time->Show();
		return TRUE;
	}

	public function onRun($model = NULL){


		//$this->SetView(SYS.V.'index');
		//if($this->error == 404) $this->Exceptions(NULL,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
		
		$this->ViewData('title', "XSL");
		$this->ViewData('content', $this->model->check());
		$this->ViewData('message', " i leży " );
		$a = round(3.10, 2);
		$b = round(cpu_get_usage(), 2); //0.17
		if($a <= $b ){
    		$this->error = 2100;
			$this->emessage = "To many CPU resource used";
		}
		if($this->error == 2100){

			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');

			$this->exception->ViewData('title', "Error!!! ".$this->error);
			$this->exception->ViewData('header', "To many CPU resource used");
			$this->exception->ViewData('alert',"Server is to busy, catch error:  ");
			$this->exception->ViewData('error', $this->error);
		}	
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