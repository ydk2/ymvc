<?php
class PHPCall extends PHPRender {

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


	public function onException(){
			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');

			$this->exception->ViewData('title', "Error!!! ".$this->error);
			$this->exception->ViewData('header', $this->emessage);
			$this->exception->ViewData('alert',"<b>Please check loader options</b> Catch error:  ");
			$this->exception->ViewData('error', $this->error);
		//return TRUE;
	}
	
	public function onRun($model = NULL){
		if($this->error == 20404)
			throw new SystemException("View not exists",$this->error);
		$this->ViewData('title', "PHP View");
		$this->ViewData('header', "Controller with PHP View");
		$this->ViewData('alert', "Content for  this module");
	}

}
?>