<?php
class Two extends XSLRender {

	public function Init(){
		// call in __constructor
		$this->registerPHPFunctions();
		$this->setmodel (new stdclass);

		$this->SetAccess(self::ACCESS_ANY);
		$this->access_groups = array('admin','editor');
		$this->current_group = Helper::Session('user_role');
		$this->AccessMode(2);
		$this->global_access = Helper::Session('user_access');

		$this->exceptions = true;
		if($this->error > 0) {

			//$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');
			
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
		if($this->error == 20503 && !isset(Config::$data['tmp_data']['login'])) return $this->show_login();
		//if($this->error == 20503) return $this->showwarning();
		
	}
	public function showwarning()
	{
		$error=$this->NewControllerB(SYS.V.'errors'.DS.'warning',SYS.C.'errors'.DS.'systemerror');
		$error->setParameter('','inside','yes');
		$error->setParameter('','show_link','no');
		$error->ViewData('title', Intl::_p('Warning!!!'));
		$error->ViewData('header', Intl::_p('Warning!!!').' '.$this->error);
		$error->ViewData('alert',Intl::_p($this->emessage).' - '.Intl::_p('Try get more privilages').' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
	}

	public function showerror()
	{
		$error=$this->NewControllerB(SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');
		$error->setParameter('','inside','yes');
		$error->setParameter('','show_link','no');
		$error->ViewData('title', Intl::_p('Error!!!'));
		$error->ViewData('header', Intl::_p('Error!!!').' '.$this->error);
		$error->ViewData('alert',Intl::_p($this->emessage).' - '.Intl::_p('Try get more privilages').' - ');
		$error->ViewData('error', $this->error);
		return $error->View();
	}

	public function Run($model = NULL){
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

	public function show_login()
	{
		$login=$this->NewControllerA(SYS.C.'admin:account');
		return $login->View();
	}
}
?>