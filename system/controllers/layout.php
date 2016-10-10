<?php
class Layout extends XCoreRender {
	private $time;
	public function onInit(){
		// call in __constructor
		$this->time[0]=get_time();
		$this->SetModel(SYS.M.'model');
		$this->registerPHPFunctions();
		$this->only_registered_views = TRUE;
		$this->RegisterView(SYS.V.strtolower($this->name));
		$this->RegisterView(SYS.V.'errors'.DS.'error');
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


		if($this->error == 20402){

			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');

			$this->exception->ViewData('title', "Error!!! ".$this->error);
			$this->exception->ViewData('header', "View not register");
			$this->exception->ViewData('alert',"<b>Please register view in onInit function or set only_registered_views to FALSE </b> Catch error:  ");
			$this->exception->ViewData('error', $this->error);
		} 
		foreach ($this->model->get() as $key => $value) {
			$this->ViewData($value['name'], $value['string']);
		} 
		if(Helper::Get('phpview')=="yes"){
			$this->Register(NULL,SYS.V.'index',SYS.C.'index');
			//var_dump($this->modules);
			$this->ViewData('php_view', $this->modules['index']->View());
		} else {
		//$this->SetView(SYS.V.'index');
		//if($this->error == 404) $this->Exceptions(NULL,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'error');
			$this->routing();
		}
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
		$i = 0;
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
					if($key != 'two')
					$i++;
			}
		}
		foreach ($array as $key => $value) {
			if(!in_array($key,$disabled)){
				$viewer = $this->Viewer(SYS.V.$value,SYS.C.$key);
				if(is_object($viewer)){
					if($i == 0)
					$viewer->setParameter('','show_link','yes');
					$this->data->addChild('content',$viewer->View());
				}
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