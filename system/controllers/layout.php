<?php
class Layout extends XCoreRender {
	private $time;
	public function onInit(){
		// call in __constructor
		$this->time[0]=get_time();
		$this->SetModel(SYS.M.'model');
		$this->registerPHPFunctions();
		if(isset($_GET['errors']))
		$this->error = $_GET['errors'];
		if($this->error > 0) {

			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');

			$this->exception->ViewData('title', "Error!!! ".$this->error);
			$this->exception->ViewData('header', "Error on Site!!!");
			$this->exception->ViewData('alert',"Catch system error: ");
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
		$model->cpu = round(cpu_get_usage(),2);
		$model->mem = convert(memory_get_usage());
		$model->time = get_time_exec($this->time[0],$this->time[1]);

		$time = $this->Loader($model,SYS.V.'time',SYS.C.'view');
		$time->Show();
		return TRUE;
	}

	public function onRun($model = NULL){


		foreach ($this->model->get() as $key => $value) {
			$this->ViewData($value['name'], $value['string']);
		}
		//$this->SetView(SYS.V.'index');
		//if($this->error == 404) $this->Exceptions(NULL,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
		$this->routing();
		$a = round(Config::$data['default']['cpu_limit'], 2);
		$b = round(cpu_get_usage(), 2); //0.17
		if($a <= $b ){
    		$this->error = 2100;
			$this->emessage = "To many CPU resource used";
		}
		if($this->error == 2100){

			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');

			$this->exception->ViewData('title', "Error!!! ".$this->error);
			$this->exception->ViewData('header', "To many CPU resource used");
			$this->exception->ViewData('alert',"<b>Server is to busy, is limited to ".Config::$data['default']['cpu_limit'] .".</b> Catch error:  ");
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
	public function routing(){
		$loader = new Loader;
		$disabled = array('error','errors','data','item','action','layout');
		$controller = 'one';
		$view = 'one';

		$array = $_GET;
		
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$viewer = $this->Viewer(SYS.V.$value,SYS.C.$key);
				if(is_object($viewer))
				$this->data->addChild('content',$viewer->View());
			}
		}
		if(!isset($this->data->content)){
			$viewer = $this->Viewer(SYS.V.$view,SYS.C.$controller);
			if(is_object($viewer))
			$this->ViewData('content', $viewer->View());
		}
	}
	
}
?>