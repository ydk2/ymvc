<?php
class view extends CoreRender {

	public function Init($model = NULL){
		$this->Model(SYS_M.'model');
		//$this->model = new Model;
		//$this->view = SYS_V.'view';
		$this->SetView(SYS_V.'index');
		//if($this->error == 404) $this->Exceptions(NULL,SYS_V.'errors'.DS.'error',SYS_C.'errors'.DS.'error');
		if(isset($_GET['error']))
		$this->error = $_GET['error'];
		$this->message = convert(memory_get_usage(TRUE));
		$this->registerPHPFunctions();
		$this->ViewData('title', "PHP");
		$this->ViewData('content', "kupa tak i śmierdzi");
		$this->ViewData('content', $this->model->check());
		$this->ViewData('message', " i leży " );
		$this->setParameter('', 'test', convert(memory_get_usage(TRUE))." ".cpu_get_usage());
		
$url=(isset($_SERVER['HTTPS']))?'https://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/':'http://'.dirname($_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']).'/';
		$this->ViewData('message', " i leży tu ".$url);

		
	//	$this->setParameter('', 'test', convert(memory_get_usage(TRUE))." ".cpu_get_usage());
		if($this->error > 0) $this->Exceptions($this->model,SYS_V.'errors'.DS.'error',SYS_C.'errors'.DS.'errors');
	}
	protected function test(){
		$retarr = "";
		foreach(PDO::getAvailableDrivers() as $driver)
       {
       $retarr .= '<p>'.$driver.'</p>';
       }
	   return $retarr;
	}
	
}
?>