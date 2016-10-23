<?php
class PHPCall extends PHPRender {

	public function onInit(){
		// call in __constructor
		$this->registerPHPFunctions();
		Intl::set_path(SYS.LANGS);
		$langs = Intl::available_locales(Intl::PO);
		$this->langs = $langs;
		if(!Helper::Session('locale'))
			Helper::Session_Set('locale',Intl::get_browser_lang($langs));
			Intl::load_locale_simple(Helper::Session('locale'),$this->name);
		
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
			throw new SystemException(Intl::_("Not Found",'main_index'),$this->error);

		$this->ViewData('title', Intl::_("No",$this->name));
		$this->ViewData('header', str_replace('\n','<br>',Intl::_('Posts Tagged:',$this->name)));
	}

}
?>