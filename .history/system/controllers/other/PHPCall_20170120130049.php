<?php
class PHPCall extends PHPRender {

	public function Init(){
		// call in __constructor
		$this->registerPHPFunctions();
		Intl::set_path(SYS.LANGS.'phpcall');
		$langs = Intl::available_locales(Intl::PO);
		$lang_ = array('pl-PL','en-US');
		//echo Intl::get_browser_lang($lang_);
		Intl::po_locale_plural(Helper::Session('locale'),'phpcall');
		
	//	Intl::load_locale(Helper::Session('locale'),'po_phpcall');
		
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


	public function Exception(){
			$this->Exceptions($this->model,SYS.V.'errors'.DS.'error',SYS.C.'errors'.DS.'systemerror');

			$this->exception->ViewData('title', "Error!!! ".$this->error);
			$this->exception->ViewData('header', $this->emessage);
			$this->exception->ViewData('alert',"<b>Please check loader options</b> Catch error:  ");
			$this->exception->ViewData('error', $this->error);
		//return TRUE;
	}
	
	public function Run($model = NULL){
		if($this->error == 20404)
			throw new SystemException(Intl::_("Not Found"),$this->error);
$text = "Whatever you were looking for was not found, but maybe try looking again or ".
		"search using the form below.";
		$this->ViewData('title', Intl::_($text,$this->name));
		$this->ViewData('header', str_replace('\n','<br>',Intl::_('Category:',$this->name)));
	}

}
?>