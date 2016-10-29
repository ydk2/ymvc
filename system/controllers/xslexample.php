<?php
class XSLExample extends XSLRender {

	public function onInit(){
		// call in __constructor
		Intl::set_path(SYS.LANGS);
		$langs = Intl::available_locales(Intl::PO);
			if(!Helper::Session('locale'))
				Helper::Session_Set('locale',Intl::get_browser_lang($langs));
				Intl::po_locale_plural(Helper::Session('locale'),$this->name);

		$this->SetModel(SYS.M.'model');

		$this->registerPHPFunctions();
		
		$this->only_registered(TRUE);
		$this->RegisterView(SYS.V.strtolower($this->name));
		$this->RegisterView(SYS.V.'errors'.DS.'error');

		$this->access = self::ACCESS_ANY;
		$this->SetAccessMode(Helper::Session('user_access'),TRUE);

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
		$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');
		$this->exception->setParameter('','inside','yes');
		$this->exception->setParameter('','show_link','yes');
		$this->exception->ViewData('title', Intl::_p('Error!!!',$this->name));
		$this->exception->ViewData('header', Intl::_p('Error!!!',$this->name).' '.$this->error);
		$this->exception->ViewData('alert',Intl::_p($this->emessage,'main_index').' - '.Intl::_p('Catch Error',$this->name).' - ');
		$this->exception->ViewData('error', $this->error);
	}

	public function onRun($model = NULL){
		//$this->SetView(SYS.V.'time');
		$this->ViewData('title', Intl::_p('XSLExample',$this->name));
		$this->ViewData('content', Intl::_p("Content for XSLExample" ,$this->name));
		$this->ViewData('links', "" );
		$links = $this->data->links->addChild('a',Intl::_p('Link',$this->name));
		$links->addAttribute('href', HOST_URL);
		if($this->error > 0) throw new SystemException(Intl::_p('Error',$this->name),$this->error);
	}	
	public function test($a='a test', $b='b test'){
		$this->ViewData('message', " Content for call XSLExample &amp; ".$a." ".$b );
	}
}
?>