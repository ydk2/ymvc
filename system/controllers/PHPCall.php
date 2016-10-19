<?php
class PHPCall extends PHPRender {

	public function onInit(){
		// call in __constructor
		$this->registerPHPFunctions();
		Intl::set_path(SYS.LANGS);
		$langs = Intl::available_locales(Intl::PO);
		$this->langs = $langs;
		//var_dump($langs);
		//Intl::set_mode(Intl::PO);

			if(!Helper::Session('locale'))
				Helper::Session_Set('locale',Intl::get_browser_lang($langs));
				Intl::load_locale(Helper::Session('locale'),'po_phpcall');
		
	//	Intl::load_locale(Helper::Session('locale'),'po_phpcall');
		//var_dump(Intl::$strings);
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

		$this->ViewData('title', Intl::_("Whatever you were looking for was not found, but maybe try looking again or search using the form below.",'po_phpcall'));
		$this->ViewData('header', str_replace('\n','<br>',Intl::_('Posts Tagged:','po_phpcall')));
	}

}
?>