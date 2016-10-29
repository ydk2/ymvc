<?php
class Two extends XSLRender {

	public function onInit(){
		// call in __constructor
		$this->registerPHPFunctions();
		$this->model = new stdclass;

		$this->access = 3;
		$this->SetAccessMode(Helper::Session('user_access'),TRUE);
		if($this->error > 0) {

			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');
			$this->exception->setParameter('','inside','yes');
			$this->exception->ViewData('title', Intl::_p('Error!!!','main_index'));
			$this->exception->ViewData('header', Intl::_p('Error!!!','main_index').' '.$this->error);
			$this->exception->ViewData('alert',Intl::_p($this->emessage,'main_index').' - '.Intl::_p('Try get more privilages','main_index').' - ');
			$this->exception->ViewData('error', $this->error);
		}
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
		//echo "";
	}

	public function onRun($model = NULL){
		//$this->SetView(SYS.V.'time');
		$this->ViewData('title', 'Section Two');
		$this->ViewData('message', " Content for Two" );
		$this->ViewData('links', "" );
		$links = $this->data->links->addChild('a','Index');
		$links->addAttribute('href', HOST_URL);
//	if($this->error > 0) $this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'errors');
	}	
	public function test($a='a test', $b='b test'){
		$this->ViewData('message', " Content for Two &amp; ".$a." ".$b );
	}
}
?>